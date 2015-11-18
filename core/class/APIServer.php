<?php

/*
 * ©2014 Croce Rossa Italiana
 * 
 * Per una documentazione delle API, visita:
 * https://github.com/CroceRossaCatania/gaia/wiki/API
 *
 */

class APIServer {
    
    private
        $db         = null,
        $sessione   = null,
        $chiave     = null;
    
    public
        $par        = [];
    
    public function __construct( $chiave, $sid = null ) {
        global $db, $sessione;
        $this->db = $db;
        $this->sessione = new Sessione($sid);

        /* Punta alla variabile globale, così da
         * permettere il funzionamento delle funzioni
         * Utente->admin() e tutte quelle che fanno
         * affidamento allo stato in sessione */
        $sessione = $this->sessione;

        $this->chiave = APIKey::by('chiave', $chiave);

        $identificato = (bool) $this->sessione->utente;
        if ( $identificato ) {
            registraParametroTransazione('uid', $this->sessione->utente );
        }
        registraParametroTransazione('login', (int) $identificato );
    }

    /**
     * Esegue l'azione e torna il JSON
     */    
    public function esegui( $azione = 'ciao' ) {
        $output = $this->_esegui($azione);
        return json_encode($output);
    }

    /**
     * Esegue l'azione con i parametri specificati
     */
    private function _esegui ( $azione ) {
        $start = microtime(true);
        if (empty($azione)) { $azione = 'ciao'; }
        $azione = str_replace(':', '_', $azione);
        try {
            // Controlla la validita' della chiave API usata
            if ( !$this->chiave || !$this->chiave->usabile()) {
                throw new Errore(1014);
            }

            // Contatore delle richieste
            $this->chiave->aggiorna();

            // Chiama il metodo richiesto
            if ( method_exists( $this, 'api_' . $azione ) ) {
                $r = call_user_func( [$this, 'api_' . $azione] );
            } else {
                throw new Errore(1004);
            }
            
        } catch (Errore $e) {
            $r = $e->toJSON();
        }
        
        $output = [
            'richiesta'  => [
                'metodo'        =>  $azione,
                'parametri'     =>  $this->par,
                'data'          =>  (new DT())->toJSON()
            ],
            'tempo'    => round(( microtime(true) - $start ), 6),
            'q'        => $this->db->numQuery,
            'sessione' => $this->sessione->toJSON(),
            'risposta' => $r
        ];
        $this->encoding($output); // UTF-8 safe
        return $output;
    }

    /**
     * Effettua dovuti controlli di encoding sull'output
     */
    private function encoding(&$output) {
        array_walk_recursive ($output, function (&$a) {
            if (is_string($a) && !mb_check_encoding($a, 'UTF-8')) {
                $a = utf8_encode ($a);
            }
        });
    }
        
    private function richiediLogin() {
        if ( !$this->sessione->utente ) {
            throw new Errore(1010);
        }
        return $this->sessione->utente();
    }

    private function richiedi ( $campi ) {
        foreach ( $campi as $campo ) {
            if ( empty($this->par[$campo] ) ) {
                $e = new Errore(1011);
                $e->extra = (string) $campo;
                throw $e;
            }
        }
    }

    /**
     * Esegui piu' chiamate e ritorna il risultato...
     */
    private function api_multi() {
        $this->richiedi(['richieste']);

        if ( !is_array($this->par['richieste']) )
            return ['risultato' => []];

        $iniziali = $this->par;
        $r = [];
        foreach ($this->par['richieste'] as $richiesta) {
            $metodo    = $richiesta->metodo;
            $this->par = (array) $richiesta->parametri;
            $risultato = $this->_esegui($metodo);
            unset($risultato['sessione']);
            $r[]       = $risultato;
        }
        $this->par = $iniziali;
        return ['risultato' => $r];
    }
        
    /**
     * Richiesta di ping
     */
    private function api_ciao() {
        global $conf;
        return [
            'versione'                  =>  $conf['versione'],
            'nome'                      =>  $conf['nome'],
            'organizzazione'            =>  $conf['organizzazione'],
            'copyright'                 =>  $conf['copyright'],
            'stato'                     =>  $conf['stato'],
            'documentazione'            =>  $conf['documentazione']
        ];
    }
    
    /**
     * Dettagli utente attuale
     */
    private function api_utente() {
        $this->richiedi(['id']);
        $u = Utente::id($this->par['id']);

        $conAvatar = true;
        if ( isset($this->par['conAvatar']) )
            $conAvatar = (bool) $this->par['conAvatar'];

        return $u->toJSON($conAvatar);
    }

    /**
     * Ritorna un url di login
     */
    private function api_login() {
        $this->sessione->logout();
        $sid = $this->sessione->id;

        $redirect = false;
        if ( isset($this->par['redirect']) )
            $redirect = $this->par['redirect'];

        $val    = new Validazione;
        $token  = $val->generaValidazione(
            null,
            VAL_ATTESA,
            json_encode([
                'app'       =>  $this->chiave->id,
                'ip'        =>  $_SERVER['REMOTE_ADDR'],
                'sid'       =>  $sid,
                'redirect'  =>  $redirect
            ])
        );

        $url = "https://gaia.cri.it/?p=login&token={$token}";
        return [
            'url'       =>  $url,
            'token'     =>  $token
        ];
    }
    
    /**
     * Effettua il logout
     */
    private function api_logout() {
        $this->richiediLogin();
        $this->sessione->logout();
        return [
            'ok' =>  true
        ];
    }

    /**
     * Ricerca titoli per nome
     */    
    private function api_titoli_cerca() {
        $t = [];
        if (!isset($this->par['t'])) { $this->par['t'] = -1; }
        foreach ( Titolo::cerca($this->par['query'], $this->par['t']) as $titolo ) {
            $t[] = [$titolo->id, $titolo->nome];
        }
        return $t;
    }

    /**
     * Elenco turni nel tempo
     */
    private function api_attivita() {
        global $conf;
        $inizio = DT::daISO($this->par['inizio']);
        $fine   = DT::daISO($this->par['fine']);
        $cA = Turno::neltempo($inizio, $fine);
        $searchPuoPart = [];
        $r = [];
        $utente = $this->sessione->utente();
        if ( $utente->admin ) {
            ignoraTransazione();
        }
        if (!$utente){
            $mioGeoComitato = null;
        } else {
            $mioGeoComitatoOid = $utente->unComitato()->oid();
            $mioGeoComitato = GeoPolitica::daOid($mioGeoComitatoOid);
        }
        foreach  ( $cA as $turno ) {
            $attivita = $turno->attivita();
            $idAttivita = ''.$attivita->id;
            if(!isset($searchPuoPart[$idAttivita])) {
                $searchPuoPart[$idAttivita] = $attivita->puoPartecipare($utente);
            }
            if ( !$searchPuoPart[$idAttivita] ) {
                continue;
            }
            $geoAttivita = GeoPolitica::daOid($attivita->comitato);
            if ( $mioGeoComitato ) {
                if ( $geoAttivita->contiene($mioGeoComitato) ) {
                    $colore = $conf['attivita']['colore_mie'];
                    if ( $turno->scoperto() ) {
                        $colore = $conf['attivita']['colore_scoperto'];
                    }
                } else {
                    $colore = $conf['attivita']['colore_pubbliche'];
                }
            } else {
                $colore = $conf['attivita']['colore_anonimi'];
            }
            $r[] = [
                'turno'         =>  [
                    'id'        =>  $turno->id,
                    'nome'      =>  $turno->nome
                ],
                'attivita'      =>  [
                    'id'        =>  $turno->attivita,
                    'nome'      =>  $attivita->nome
                ],  
                'inizio'        =>  $turno->inizio()->toJSON(),
                'fine'          =>  $turno->fine()->toJSON(),
                'organizzatore' =>  $geoAttivita->toJSON(),
                'colore'        =>  '#' . $colore,
                'url'           =>  'https://gaia.cri.it/?p=attivita.scheda&id=' . $attivita->id . '#'. $turno->id
            ];
        }
        return [
            'turni'  => $r
        ];
    }
    
    /**
     * Elenco corsi nel tempo
     */
    private function api_corsi() {
        /*TODO*/
        global $conf;

        $filter = $this->par;
        $corsi = Corso::ricerca($filter);
        
        $list = array();
        foreach  ( $corsi as $corso ) {
            $inizio = DT::daTimestamp($corso->inizio);
            $fine   = DT::daTimestamp($corso->inizio);
            
            $tmp = [
                'corso'         =>  [
                    'id'        =>  $corso->id,
                    'nome'      =>  $corso->luogo,
                ], 
                'inizio'        =>  $inizio->toJSON(),
                'fine'          =>  $fine->toJSON(),
                'type'          =>  $corso->certificato,
                'provincia'     =>  $corso->provincia,
                'latitude'      =>  $latitude_value[$i%3],
                'longitude'     =>  $longitude_value[$i%3],
                'organizzatore' =>  $corso->organizzatore,
                'colore'        =>  '#' . $colore,
                'url'           =>  '/?p=public.corso.scheda&id=' . $corso->id
            ];
         
            array_push($list, $tmp);
        }
  
        return [
            'corsi'  => $list
        ];
       
    }
    
    
    /**
     * Elenco corsi nel tempo
     */
    private function api_miei_corsi() {
        /*TODO*/
        global $conf;

        $filter = $this->par;
        $me = $this->richiediLogin();
        $corsi = Corso::ricerca($filter, null, $me);
        
        $list = array();
        foreach  ( $corsi as $corso ) {
            $inizio = DT::daTimestamp($corso->inizio);
            $fine   = DT::daTimestamp($corso->inizio);
            
            $tmp = [
                'corso'         =>  [
                    'id'        =>  $corso->id,
                    'nome'      =>  $corso->luogo,
                ], 
                'inizio'        =>  $inizio->toJSON(),
                'fine'          =>  $fine->toJSON(),
                'type'          =>  $corso->certificato,
                'provincia'     =>  $corso->provincia,
                'latitude'      =>  $latitude_value[$i%3],
                'longitude'     =>  $longitude_value[$i%3],
                'ruolo'         =>  $corso->ruolo,
                'organizzatore' =>  $corso->organizzatore,
                'colore'        =>  Utility::colorByRuolo($corso->ruolo),
                'url'           =>  '/?p=public.corso.scheda&id=' . $corso->id
            ];
         
            array_push($list, $tmp);
        }
  
        return [
            'corsi'  => $list
        ];
       
    }
    
    
    /**
     * Elenco corsi nel tempo
     */
    private function api_miei_corsi_in_gestione() {
        /*TODO*/
        global $conf;

        $filter = $this->par;
        $corsi = Corso::ricerca($filter);
        
        $list = array();
        foreach  ( $corsi as $corso ) {
            $inizio = DT::daTimestamp($corso->inizio);
            $fine   = DT::daTimestamp($corso->inizio);
            
            $tmp = [
                'corso'         =>  [
                    'id'        =>  $corso->id,
                    'nome'      =>  $corso->luogo,
                ], 
                'inizio'        =>  $inizio->toJSON(),
                'fine'          =>  $fine->toJSON(),
                'type'          =>  $corso->certificato,
                'provincia'     =>  $corso->provincia,
                'latitude'      =>  $latitude_value[$i%3],
                'longitude'     =>  $longitude_value[$i%3],
                'organizzatore' =>  $corso->organizzatore,
                'colore'        =>  Utility::colorByStato($corso->stato),
                'url'           =>  '/?p=formazione.corsi.riepilogo&id=' . $corso->id
            ];
         
            array_push($list, $tmp);
        }
  
        return [
            'corsi'  => $list
        ];
       
    }
    
    
    private function api_attivita_dettagli() {
        $this->richiedi(['id']);
        $me = $this->richiediLogin();
        $a = Attivita::id($this->par['id']);
        $t = [];
        foreach ( $a->turni() as $turno ) {
            $t[] = $turno->toJSON($me);
        }
        array_merge($t, [
            'luogo'          =>  $a->luogo,
            'coordinate'     =>  $a->coordinate(),
            'puoPartecipare' =>  $a->puoPartecipare($me)
        ]);
        return [
            'nome'        => $a->nome,
            'comitato'    => $a->comitato()->toJSON(),
            'descrizione' => $a->descrizione,
            'referente'   => [
                              'id'     => $a->referente()->id,
                              'nome'   => $a->referente()->nomeCompleto(),
                              'numero' => $a->referente()->cellulare(), 
                              'email'  => $a->referente()->email()
                             ],
            'luogo'       => $a->luogo,
            'coordinate'  => $a->coordinate(),
            'turni'       => $t
        ];
    }

    private function api_turno_partecipa() {
        $this->richiedi(['id']);
        $me = $this->richiediLogin();
        $t = Turno::id($this->par['id']);
        $val=$t->chiediPartecipazione($me);
        $r = [];
        $r['ok'] = $val;
        if( $val){
        	$r['id'] = $t->partecipazione($me)->id;
        }
        return $r;
    }

    private function api_partecipazioni() {
        $me = $this->richiediLogin();
        $r = [];
        foreach ( $me->partecipazioni() as $p ) {
            $r[] = $p->toJSON();
        }
        return [
	    'risultati' => $r
	];
    }

    private function api_partecipazione_ritirati() {
        $me = $this->richiediLogin();
        $this->richiedi(['id']);
        $t = Partecipazione::id($this->par['id']);
        if ( $t->volontario()->id == $me->id ) {
            $ok = $t->ritira();
        } else {
            $ok = false;
        }
        return [
            'ok'    =>  $ok
        ];
    }
    
    private function api_rubrica_delegati() {
    	$me = $this->richiediLogin();
    	$ccompetenza = $me->comitatiDiCompetenza();
    	$comitati = $me->comitati();
    	$locale = $me->unComitato()->locale();
    	array_push($comitati, $locale);
    	if ($ccompetenza)
    		$comitati = array_merge($comitati, $ccompetenza);
    	$comitati = array_unique($comitati);
    	 
    	$delegati = [];
    	 
    	foreach ( $comitati as $comitato ) {
    		$delegati = array_merge($delegati, $comitato->volontariDelegati());
    	}
    	$delegati = array_unique($delegati);
    	$r=[];
    	foreach ( $delegati as $delegato ) {
    		$_v = Volontario::id($delegato);
    		$d = $_v->delegazioni();
    		$del=[];
    		foreach ($d as $_d) {
    			$delega=[];
    			$delega['applicazione'] = $_d->applicazione;
    			$delega['comitato'] = $_d->comitato()->nomeCompleto();
    			if ($_d->applicazione == APP_OBIETTIVO) {
    				$delega['obiettivo'] = $_d->dominio;;
    			}
    			if ($_d->applicazione == APP_ATTIVITA) {
    				$delega['area'] = $_d->dominio;
    			}
    			$del[] = $delega;
    		}
    		$r[] = [
    		'avatar'  =>  $_v->avatar()->URL(),
    		'nome'    =>  $_v->nome,
    		'cognome' =>  $_v->cognome,
    		'numero'  =>  $_v->cellulare(),
    		'email'   =>  $_v->email(),
    		'deleghe' =>  $del
    		];
    	}
    	return [
    	'risultati' => $r
    	];
    }
    
    private function api_rubrica() {
    	$me = $this->richiediLogin();
    	$comitato = $me->unComitato();
    	$volontari = $comitato->locale()->tuttiVolontari();
    
    	foreach ( $volontari as $_v ) {
    		if($_v->privacy()->contatti($me)) {
    			$r[] = [
    			'avatar'  =>  $_v->avatar()->URL(),
    			'nome'    =>  $_v->nome,
    			'cognome' =>  $_v->cognome,
    			'numero'  =>  $_v->cellulare(),
    			'email'   =>  $_v->email(),
    			'comitato'=>  $_v->unComitato()->nome
    			];
    		}
    	}
    	return [
    	'risultati' => $r
    	];
    }
         
     private function api_geocoding() {
        $this->richiedi(['query']);
        $g = new Geocoder($this->par['query']);
        return $g->risultati;
    }
    
    private function api_io() {
        global $conf;
        $me = $this->richiediLogin();
        $r = [];
        $r['anagrafica'] = [
            'nome'              =>  $me->nome,
            'cognome'           =>  $me->cognome,
            'sesso'             =>  $conf['sesso'][$me->sesso],
            'codiceFiscale'     =>  $me->codiceFiscale,
            'email'             =>  $me->email,
            'emailServizio'     =>  $me->emailServizio,
            'dataNascita'       =>  date('d/m/Y', $me->dataNascita),
            'cellulare'         =>  $me->cellulare,
            'cellulareServizio' =>  $me->cellulareServizio,
            'avatar'            =>  $me->avatar()->URL()
        ];
        $r['appartenenze'] = [];
        foreach ( $me->appartenenzeAttuali() as $app ) {
            $r['appartenenze'][] = [
                'id'        =>  $app->id,
                'comitato'  =>  [
                    'id'    =>  $app->comitato()->id,
                    'nome'  =>  $app->comitato()->nome
                ],
                'inizio'    =>  $app->inizio()->toJSON(),
                'stato'     =>  [
                    'id'    =>  (int) $app->stato,
                    'nome'  =>  $conf['membro'][$app->stato]
                ]
            ];
        }       
        $r['delegazioni'] = [];
        foreach ( $me->delegazioni() as $d ) {
            $r['delegazioni'][] = [
                'id'        =>  $d->id,
                'comitato'  =>  $d->comitato()->oid(),
                'inizio'    =>  $d->inizio()->toJSON(),
                'app'       =>  [
                    'id'        =>  (int) $d->applicazione,
                    'dominio'   =>  (int) $d->dominio,
                    'nome'      =>  $conf['applicazioni'][$d->applicazione]
                ]
            ];
        }
        return $r;
    }
        
    private function api_comitati() {
        return GeoPolitica::ottieniAlbero();
    }
    	
    private function api_autorizza() {
        $this->richiedi(['id']);
        $this->richiediLogin();
        $aut = Autorizzazione::id($this->par['id']);
        if ( $aut->stato == AUT_PENDING ) {
            
            $turno = $aut->partecipazione()->turno();
            $attivita = $turno->attivita();
            
            if ( $this->par['aut'] ) {
                $aut->concedi();

                $cal = new ICalendar();
                $cal->genera($attivita->id, $turno->id);
                
                
                $m = new Email('autorizzazioneConcessa', "Autorizzazione CONCESSA: {$attivita->nome}, {$turno->nome}" );
                $m->a = $aut->partecipazione()->volontario();
                $m->da = $attivita->referente();
                $m->_NOME       = $aut->partecipazione()->volontario()->nome;
                $m->_ATTIVITA   = $attivita->nome;
                $m->_TURNO      = $turno->nome;
                $m->_DATA      = $turno->inizio()->format('d-m-Y H:i');
                $m->_LUOGO     = $attivita->luogo;
                $m->_REFERENTE   = $attivita->referente()->nomeCompleto();
                $m->_CELLREFERENTE = $attivita->referente()->cellulare();
                $m->allega($cal);
                $m->invia(true);
                
                
            } else {
                $aut->nega();
                                    
                $m = new Email('autorizzazioneNegata', "Autorizzazione NEGATA: {$attivita->nome}, {$turno->nome}" );
                $m->a = $aut->partecipazione()->volontario();
                $m->da = $attivita->referente();
                $m->_NOME       = $aut->partecipazione()->volontario()->nome;
                $m->_ATTIVITA   = $attivita->nome;
                $m->_TURNO      = $turno->nome;
                $m->_DATA       = $turno->inizio()->format('d-m-Y H:i');
                $m->_LUOGO      = $attivita->luogo;
                $m->_MOTIVO     = $this->par['motivo'];
                $m->invia();
                
            }
        }
        return [ 
                    'id' => $aut 
                ];
    }
    
    private function api_scansione() {
        $this->richiediLogin();
        $this->richiedi(['code']);
        $a = Volontario::by('codiceFiscale', $this->par['code']);
        if (!$a) { return null; }
        return [
            'nomeCompleto'  =>  $a->nomeCompleto(),
            'comitato'      =>  $a->unComitato()->nomeCompleto()
        ];
    }

    private function api_area_cancella() {
        $this->richiediLogin();
        $this->richiedi(['id']);
        $area = Area::id($this->par['id']);
        if ( $area->attivita() ) {
            throw new Errore(9050);
        }
        $area->cancella();
        return true;
    }

    private function api_corsi_volontari_cerca() {
        
        $IS_POPOLAZIONE = false;
        $RUOLO_POPOLAZIONE = Utility::getIdRuoloByName("Popolazione");
        $RUOLO_SANITARIO = Utility::getIdRuoloByName("Sanitario");
        
        $me = $this->richiediLogin();
        $r = new Ricerca();
        
        /* Ordini personalizzati per vari usi */
        $r->ordine = [
            'anagrafica.cognome     ASC',
            'anagrafica.nome        ASC'
        ];
        /*
        if ( 
            $this->par['ordine'] &&
            isset($ordini[$this->par['ordine']])
            ) {
             $ordini[$this->par['ordine']];
        }
         * 
         */
        
        
        if ($this->par['stato']) {
            $r->stato = $this->par['stato'];
        } elseif ($this->par['stato'] === 0) {
            $r->stato = 0;
        }

        if ($this->par['statoPersona']) {
            $r->statoPersona = $this->par['statoPersona'];
        } elseif ($this->par['statoPersona'] === 0) {
            $r->statoPersona = 0;
        } else {
            $r->statoPersona = false;
        }

        if ($this->par['passato']) {
            $r->passato = true;
        }

        if ($this->par['giovane']) {
            $r->giovane = true;
        }

        if ($this->par['infermiera']) {
            $r->infermiera = true;
        }

        if ($this->par['militare']) {
            $r->militare = true;
        }
        
        if ($this->par['qualifica']) {
            $r->crs_qualifica = $this->par['qualifica'];
        }
        
        $ruolo = $this->par['ruolo'];
        if ($ruolo){
            switch ($ruolo){
                case $RUOLO_POPOLAZIONE:
                    $r->statoPersona = PERSONA;
                    $r->crs_qualifica = null;
                    $IS_POPOLAZIONE = TRUE;
                    break;
                case $RUOLO_SANITARIO:
                    $r->sanitario = true;
                    $r->crs_qualifica = null;
                    break;
                default: 
                    $r->crs_ruolo = $this->par['ruolo'];
                    break;
            }
        }
        
       
        
        // versione modificata per #867
        if ($this->par['comitati']) {
            $g = GeoPolitica::daOid($this->par['comitati']);
            // bisogna avere permessi di lettura sul ramo
            if ( !$me->puoLeggereDati($g) )
                throw new Errore(1016);
            
            $com = $g->estensione();
        } else {
            $com = array_merge(
                // Dominio di ricerca
                $me->comitatiApp([
                    APP_PRESIDENTE,
                    APP_SOCI,
                    APP_OBIETTIVO
                ]),
                $me->geopoliticheAttivitaReferenziate(),
                $me->comitatiAreeDiCompetenza(true)
            );
        }
        $r->comitati = $com;

        if ( $this->par['query'] ) {
            $r->query = $this->par['query'];
        }

        if ( $this->par['pagina'] ) {
            $r->pagina = (int) $this->par['pagina'];
        }

        if ( $this->par['perPagina'] ) {
            $r->perPagina = (int) $this->par['perPagina'];
        }
        
        $r->corsi_esegui($IS_POPOLAZIONE);

        $risultati = [];
        foreach ( $r->risultati as $risultato ) {
            $risultati[] = $risultato->toJSONRicerca();
        }

        $risposta = [
            'tempo'     =>  $r->tempo,
            'totale'    =>  $r->totale,
            'pagina'    =>  $r->pagina,
            'pagine'    =>  $r->pagine,
            'perPagina' =>  $r->perPagina,
            'risultati' =>  $risultati
        ];
        return $risposta;
    }
    
    private function api_volontari_cerca() {
        $me = $this->richiediLogin();
        $r = new Ricerca();

        /* Ordini personalizzati per vari usi */
        $ordini = [
            'selettore' =>  [
                'pertinenza DESC'
            ]
        ];
        if ( 
            $this->par['ordine'] &&
            isset($ordini[$this->par['ordine']])
            ) {
            $r->ordine = $ordini[$this->par['ordine']];
        }

        if ($this->par['stato']) {
            $r->stato = $this->par['stato'];
        } elseif ($this->par['stato'] === 0) {
            $r->stato = 0;
        }

        if ($this->par['statoPersona']) {
            $r->statoPersona = $this->par['statoPersona'];
        } elseif ($this->par['statoPersona'] === 0) {
            $r->statoPersona = 0;
        } else {
            $r->statoPersona = false;
        }

        if ($this->par['passato']) {
            $r->passato = true;
        }

        if ($this->par['giovane']) {
            $r->giovane = true;
        }

        if ($this->par['infermiera']) {
            $r->infermiera = true;
        }

        if ($this->par['militare']) {
            $r->militare = true;
        }

        // versione modificata per #867
        if ($this->par['comitati']) {
            $g = GeoPolitica::daOid($this->par['comitati']);
            // bisogna avere permessi di lettura sul ramo
            if ( !$me->puoLeggereDati($g) )
                throw new Errore(1016);
            
            $com = $g->estensione();
        } else {
            $com = array_merge(
                // Dominio di ricerca
                $me->comitatiApp([
                    APP_PRESIDENTE,
                    APP_SOCI,
                    APP_OBIETTIVO
                ]),
                $me->geopoliticheAttivitaReferenziate(),
                $me->comitatiAreeDiCompetenza(true)
            );
        }
        $r->comitati = $com;

        if ( $this->par['query'] ) {
            $r->query = $this->par['query'];
        }

        if ( $this->par['pagina'] ) {
            $r->pagina = (int) $this->par['pagina'];
        }

        if ( $this->par['perPagina'] ) {
            $r->perPagina = (int) $this->par['perPagina'];
        }

        $r->esegui();

        $risultati = [];
        foreach ( $r->risultati as $risultato ) {
            $risultati[] = $risultato->toJSONRicerca();
        }

        $risposta = [
            'tempo'     =>  $r->tempo,
            'totale'    =>  $r->totale,
            'pagina'    =>  $r->pagina,
            'pagine'    =>  $r->pagine,
            'perPagina' =>  $r->perPagina,
            'risultati' =>  $risultati
        ];
        return $risposta;

    }
    

    private function api_direttori_cerca() {
        $me = $this->richiediLogin();
        $r = new Ricerca();

        /* Ordini personalizzati per vari usi */
        $ordini = [
            'selettore' =>  [
                'pertinenza DESC'
            ]
        ];
        if ( 
            $this->par['ordine'] &&
            isset($ordini[$this->par['ordine']])
            ) {
            $r->ordine = $ordini[$this->par['ordine']];
        }

        if ($this->par['stato']) {
            $r->stato = $this->par['stato'];
        } elseif ($this->par['stato'] === 0) {
            $r->stato = 0;
        }

        if ($this->par['statoPersona']) {
            $r->statoPersona = $this->par['statoPersona'];
        } elseif ($this->par['statoPersona'] === 0) {
            $r->statoPersona = 0;
        } else {
            $r->statoPersona = false;
        }

        if ($this->par['passato']) {
            $r->passato = true;
        }

        if ($this->par['giovane']) {
            $r->giovane = true;
        }

        if ($this->par['infermiera']) {
            $r->infermiera = true;
        }

        if ($this->par['militare']) {
            $r->militare = true;
        }

        // versione modificata per #867
        if ($this->par['comitati']) {
            $g = GeoPolitica::daOid($this->par['comitati']);
            // bisogna avere permessi di lettura sul ramo
            if ( !$me->puoLeggereDati($g) )
                throw new Errore(1016);
            
            $com = $g->estensione();
        } else {
            $com = array_merge(
                // Dominio di ricerca
                $me->comitatiApp([
                    APP_PRESIDENTE,
                    APP_SOCI,
                    APP_OBIETTIVO
                ]),
                $me->geopoliticheAttivitaReferenziate(),
                $me->comitatiAreeDiCompetenza(true)
            );
        }
        $r->comitati = $com;

        if ( $this->par['query'] ) {
            $r->query = $this->par['query'];
        }

        if ( $this->par['pagina'] ) {
            $r->pagina = (int) $this->par['pagina'];
        }

        if ( $this->par['perPagina'] ) {
            $r->perPagina = (int) $this->par['perPagina'];
        }

        $r->esegui();

        $risultati = [];
        foreach ( $r->risultati as $risultato ) {
            $risultati[] = $risultato->toJSONRicerca();
        }

        $risposta = [
            'tempo'     =>  $r->tempo,
            'totale'    =>  $r->totale,
            'pagina'    =>  $r->pagina,
            'pagine'    =>  $r->pagine,
            'perPagina' =>  $r->perPagina,
            'risultati' =>  $risultati
        ];
        return $risposta;

    }
    
    private function api_istruttori_cerca() {
        $me = $this->richiediLogin();
        $r = new Ricerca();

        /* Ordini personalizzati per vari usi */
        $ordini = [
            'selettore' =>  [
                'pertinenza DESC'
            ]
        ];
        if ( 
            $this->par['ordine'] &&
            isset($ordini[$this->par['ordine']])
            ) {
            $r->ordine = $ordini[$this->par['ordine']];
        }

        if ($this->par['stato']) {
            $r->stato = $this->par['stato'];
        } elseif ($this->par['stato'] === 0) {
            $r->stato = 0;
        }

        if ($this->par['statoPersona']) {
            $r->statoPersona = $this->par['statoPersona'];
        } elseif ($this->par['statoPersona'] === 0) {
            $r->statoPersona = 0;
        } else {
            $r->statoPersona = false;
        }

        if ($this->par['passato']) {
            $r->passato = true;
        }

        if ($this->par['giovane']) {
            $r->giovane = true;
        }

        if ($this->par['infermiera']) {
            $r->infermiera = true;
        }

        if ($this->par['militare']) {
            $r->militare = true;
        }

        // versione modificata per #867
        if ($this->par['comitati']) {
            $g = GeoPolitica::daOid($this->par['comitati']);
            // bisogna avere permessi di lettura sul ramo
            if ( !$me->puoLeggereDati($g) )
                throw new Errore(1016);
            
            $com = $g->estensione();
        } else {
            $com = array_merge(
                // Dominio di ricerca
                $me->comitatiApp([
                    APP_PRESIDENTE,
                    APP_SOCI,
                    APP_OBIETTIVO
                ]),
                $me->geopoliticheAttivitaReferenziate(),
                $me->comitatiAreeDiCompetenza(true)
            );
        }
        $r->comitati = $com;

        if ( $this->par['query'] ) {
            $r->query = $this->par['query'];
        }

        if ( $this->par['pagina'] ) {
            $r->pagina = (int) $this->par['pagina'];
        }

        if ( $this->par['perPagina'] ) {
            $r->perPagina = (int) $this->par['perPagina'];
        }

        $r->esegui();

        $risultati = [];
        foreach ( $r->risultati as $risultato ) {
            $risultati[] = $risultato->toJSONRicerca();
        }

        $risposta = [
            'tempo'     =>  $r->tempo,
            'totale'    =>  $r->totale,
            'pagina'    =>  $r->pagina,
            'pagine'    =>  $r->pagine,
            'perPagina' =>  $r->perPagina,
            'risultati' =>  $risultati
        ];
        return $risposta;

    }
    
    private function api_istruttori_in_affiancamento_cerca() {
        $me = $this->richiediLogin();
        $r = new Ricerca();

        /* Ordini personalizzati per vari usi */
        $ordini = [
            'selettore' =>  [
                'pertinenza DESC'
            ]
        ];
        if ( 
            $this->par['ordine'] &&
            isset($ordini[$this->par['ordine']])
            ) {
            $r->ordine = $ordini[$this->par['ordine']];
        }

        if ($this->par['stato']) {
            $r->stato = $this->par['stato'];
        } elseif ($this->par['stato'] === 0) {
            $r->stato = 0;
        }

        if ($this->par['statoPersona']) {
            $r->statoPersona = $this->par['statoPersona'];
        } elseif ($this->par['statoPersona'] === 0) {
            $r->statoPersona = 0;
        } else {
            $r->statoPersona = false;
        }

        if ($this->par['passato']) {
            $r->passato = true;
        }

        if ($this->par['giovane']) {
            $r->giovane = true;
        }

        if ($this->par['infermiera']) {
            $r->infermiera = true;
        }

        if ($this->par['militare']) {
            $r->militare = true;
        }

        // versione modificata per #867
        if ($this->par['comitati']) {
            $g = GeoPolitica::daOid($this->par['comitati']);
            // bisogna avere permessi di lettura sul ramo
            if ( !$me->puoLeggereDati($g) )
                throw new Errore(1016);
            
            $com = $g->estensione();
        } else {
            $com = array_merge(
                // Dominio di ricerca
                $me->comitatiApp([
                    APP_PRESIDENTE,
                    APP_SOCI,
                    APP_OBIETTIVO
                ]),
                $me->geopoliticheAttivitaReferenziate(),
                $me->comitatiAreeDiCompetenza(true)
            );
        }
        $r->comitati = $com;

        if ( $this->par['query'] ) {
            $r->query = $this->par['query'];
        }

        if ( $this->par['pagina'] ) {
            $r->pagina = (int) $this->par['pagina'];
        }

        if ( $this->par['perPagina'] ) {
            $r->perPagina = (int) $this->par['perPagina'];
        }

        $r->esegui();

        $risultati = [];
        foreach ( $r->risultati as $risultato ) {
            $risultati[] = $risultato->toJSONRicerca();
        }

        $risposta = [
            'tempo'     =>  $r->tempo,
            'totale'    =>  $r->totale,
            'pagina'    =>  $r->pagina,
            'pagine'    =>  $r->pagine,
            'perPagina' =>  $r->perPagina,
            'risultati' =>  $risultati
        ];
        return $risposta;

    }

    private function api_posta_cerca() {
        $me = $this->richiediLogin();

        $r = new ERicerca();

        if ( $this->par['direzione'] == 'ingresso' ) {
            $r->direzione       = POSTA_INGRESSO;
        } else {
            $r->direzione       = POSTA_USCITA;
        }

        // Posso guardare solamente la mia posta, perche' si'
        $r->casella             = $me->id;

        if ( $this->par['pagina'] ) {
            $r->pagina = (int) $this->par['pagina'];
        }

        if ( $this->par['perPagina'] ) {
            $r->perPagina = (int) $this->par['perPagina'];
        }
        
        $r->esegui();
        
        $risposta = [
            'tempo'     =>  $r->tempo,
            'totale'    =>  $r->totale,
            'pagina'    =>  $r->pagina,
            'pagine'    =>  $r->pagine,
            'perPagina' =>  $r->perPagina,
            'risultati' =>  $r->risultati
        ];

        return $risposta;

    }


    private function api_corsobase_accetta() {
        $this->richiedi(['id']);
        $me = $this->richiediLogin();
        $part = PartecipazioneBase::id($this->par['id']);
        $corsoBase = $part->corsoBase();
        if (!$corsoBase->modificabileDa($me)) {
            return [
                'ok' => false
            ];
        }
        if ( $part->stato == ISCR_RICHIESTA ) {
            
            if ( $this->par['iscr'] ) {
                $part->concedi($this->par['com'], $me);

                $cal = new ICalendar();
                $cal->generaCorsoBase($corsoBase);
                             
                $m = new Email('corsoBaseAmmesso', "Ammesso al {$corsoBase->nome()}" );
                $m->a               = $part->utente();
                $m->da              = $corsoBase->direttore();
                $m->_NOME           = $part->utente()->nome;
                $m->_CORSO          = $corsoBase->nome();
                $m->_DATA           = $corsoBase->inizio()->inTesto(false, true);
                $m->_DIRETTORE      = $corsoBase->direttore()->nomeCompleto();
                $m->_CELLDIRETTORE  = $corsoBase->direttore()->cellulare();
                $m->allega($cal);
                $m->invia();               
                
            } else {
                $part->nega($me);
                $motivo = $this->par['motivo'];                 
                $m = new Email('corsoBaseNonAmmesso', "Non ammesso al {$corsoBase->nome()}" );
                $m->a               = $part->utente();
                $m->da              = $corsoBase->direttore();
                $m->_NOME           = $part->utente()->nome;
                $m->_MOTIVO         = $motivo;
                $m->_CORSO          = $corsoBase->nome();
                $m->_DIRETTORE      = $corsoBase->direttore()->nomeCompleto();
                $m->invia();    
                
            }
        }
        return ['id' => $corsoBase->id];
    }

    private function api_like() {
        global $conf;
        $this->richiedi(['oggetto']);
        $oggetto = Entita::daOid($this->par['oggetto']);
        $me = false;
        if ( $this->sessione->utente ) {
            $me = $this->richiediLogin();
        }
        if ( isset($this->par['tipo']) ) {
            if ( !$me ) {
                throw new Errore(1019);
            }
            $t = (int) $this->par['tipo'];
            if ( $t !== PIACE && $t !== NON_PIACE ) {
                throw new Errore(1020);
            }
            $me->apponiLike($oggetto, $t);
        }
        $p = -1;
        if ( $me && $a = $me->appostoLike($oggetto) ) {
            $p = $a->tipo;
        }        
        $r = [];
        foreach ( $conf['like'] as $tipo => $descrizione ) {
            $r[$tipo] = [
                'nome'      =>  $descrizione,
                'numero'    =>  $oggetto->like($tipo),
                'apposto'   =>  ($p == $tipo)
            ];
        }
        return $r;
    }

    private function api_tesserino_stato() {
        $this->richiedi(['codice', 'stato']);
        $me = $this->richiediLogin();
        if ( !$me->admin )
            return [
                'ok'    =>  false
            ];
        $r = TesserinoRichiesta::by('codice', $this->par['codice']);
        if ( !$r ) 
            return [
                'ok'    =>  false
            ];
        $r->pConferma = $me->id;
        $r->tConferma = time();
        $r->stato     = $this->par['stato'];
        if ( $a = $r->utente()->ultimaAppartenenza() ) {
            $c = $a->comitato()->superiore()->superiore()->superiore()->nomeCompleto();
        } else {
            $c = "Nessun Comitato Regionale";
        }
        return [
            'ok'            =>  true,
            'volontario'    =>  $r->utente()->toJSON(true),
            'regionale'     =>  $c
        ];
    }

    
    private function api_aggiungi_civile() {
        $me = $this->richiediLogin();
        $this->richiedi(['cf','nome','cognome','dnascita','conascita','prnascita']);
        $a = Civile::by('codiceFiscale', $this->par['cf']);
        if (!empty($a)) {
            return [
                'errore'    => [
                    'timestamp' => (new DT())->getTimestamp(),
                    'messaggio' => 'Civile già presente in anagrafica',
                    'info' => 'Si è cercato di inserire un civile con codice fiscale '.$this->par['cf'].', ma questo codice fiscale esiste già.'
                ]
            ];
        }
        $this->db->beginTransaction();
        try {
            $a = new Civile();
            $a->codiceFiscale = $this->par['cf'];
            
            $a->nome     = $this->par['nome'];
            $a->cognome = $this->par['cognome'];
            $a->sesso = $this->par['sesso'] ? 1 : 0;
            $a->dataNascita = DT::daFormato($this->par['dnascita'])->getTimestamp();
            
            $a->provinciaNascita = $this->par['prnascita'];
            $a->comuneNascita = $this->par['conascita'];
            $a->comuneResidenza = $this->par['coresidenza'];
            $a->CAPResidenza = $this->par['caresidenza'];
            $a->provinciaResidenza = $this->par['prresidenza'];
            $a->indirizzo = $this->par['indirizzo'];
            $a->civico = $this->par['civico'];
            
            $a->cellulare = $this->par['cellulare'];
            $a->email = $this->par['email'];
            
        } catch (Exception $e) {
            $this->db->rollBack();
            if (!$a) { return null; }
        }
        $this->db->commit();
        if (!$a) { return null; }

        return [
            'id'  =>  $a->id,
            'nomeCompleto'  =>  $a->nomeCompleto(),
            'codiceFiscale' =>  $a->codiceFiscale        ];
    }

	/**
     * Ricerca sedi donazioni per visibilita
     */    
    private function api_donazionesedi_cerca() {
		$t = [];
        foreach ( DonazioneSede::filtraDistinctSedi($this->par['res'],[[$this->par['req'],$this->par['query']]]) as $key => $value ) {
			$t[$key] = $value;
        }
        return $t;
    }

}
