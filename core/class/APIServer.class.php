<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class APIServer {
	
	private
		$db             = null,
		$sessione	= null;
	
	public
            $par		= [];
	
	public function __construct( $sid = null ) {
            global $db, $sessione;
            $this->db = $db;
            $this->sessione = new Sessione($sid);

            /* Punta alla variabile globale, così da
             * permettere il funzionamento delle funzioni
             * Utente->admin() e tutte quelle che fanno
             * affidamento allo stato in sessione */
            $sessione = $this->sessione;
	}
	
	public function esegui( $azione = 'welcome' ) {
            $start = microtime(true);
            if (empty($azione)) { $azione = 'welcome'; }
            $azione = str_replace(':', '_', $azione);
            try {
                if ( method_exists( $this, 'api_' . $azione ) ) {
                    $r = call_user_func( [$this, 'api_' . $azione] );
                } else {
                    throw new Errore(1004);
                }
            } catch (Errore $e) {
                $r = $e->toJSON();
            } 
            return json_encode([
                'request'  => [
                    'action'        =>  $azione,
                    'parameters'    =>  $this->par,
                    'time'          =>  new DateTime()
                ],
                'time'     => ( microtime(true) - $start ),
                'session'  => $this->sessione->toJSON(),
                'response' => $r
            ], JSON_PRETTY_PRINT);
	}
        
        private function richiediLogin() {
            if ( !$this->sessione->utente ) {
                throw new Errore(1010);
            }
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
        
	private function api_welcome() {
            global $conf;
            return [
                'version'   =>	$conf['version'],
                'name'      =>	$conf['name'],
                'vendor'    =>	$conf['vendor'],
                'copyright' =>	$conf['copyright'],
                'status'    =>	$conf['status'],
                'docs'      =>	$conf['docs']
            ];
	}
        
        public function api_user() {
            $this->richiedi(['id']);
            $u = Utente::id($this->par['id']);
            return $u->toJSON();
        }
	
        public function api_login() {
            $this->richiedi(['email', 'password']);
            $this->sessione->logout();
            $u = Utente::by('email', $this->par['email']);
            if (!$u) { 
                return [
                    'email'     =>  'wrong',
                    'password'  =>  'wrong',
                    'login'     =>  false
                ];
            }
            if ( $u->login($this->par['password'] ) ) {
                $this->sessione->utente = $u->id;
                return  [
                    'email'     =>  'correct',
                    'password'  =>  'correct',
                    'login'     =>  true
                ];
            } else {
                return [
                    'email'     =>  'correct',
                    'password'  =>  'wrong',
                    'login'     =>  false
                ];
            }
        }
        
        public function api_ciao() {
            $this->richiedi(['a', 'b']);
            
        }
        
        public function api_logout() {
            $this->richiediLogin();
            $this->sessione->logout();
            return [
                'success' =>  true
            ];
        }
        
        public function api_cercaTitolo() {
            $t = [];
            if (!isset($this->par['t'])) { $this->par['t'] = -1; }
            foreach ( Titolo::cerca($this->par['query'], $this->par['t']) as $titolo ) {
                $t[] = [$titolo->id, $titolo->nome];
            }
            return $t;
        }

        public function api_attivita() {
            global $conf;
            $inizio = DT::daISO($this->par['inizio']);
            $fine   = DT::daISO($this->par['fine']);
            $cA = Turno::neltempo($inizio, $fine);
            $searchPuoPart = [];
            $r = [];
            $mioComitato = $this->sessione->utente()->unComitato()->id;
            foreach  ( $cA as $turno ) {
                $attivita = $turno->attivita();
                $idAttivita = ''.$attivita->id;
                if(!isset($searchPuoPart[$idAttivita])) {
                    $searchPuoPart[$idAttivita] = $attivita->puoPartecipare($this->sessione->utente());
                }
                if ( !$searchPuoPart[$idAttivita] ) {
                    continue;
                }
                if ( $this->sessione->utente ) {
                    if ( $mioComitato == $attivita->comitato ) {
                        $colore = $conf['attivita']['colore_mie'];
                    } else {
                        $colore = $conf['attivita']['colore_pubbliche'];
                    }
                    if ( $turno->scoperto() ) {
                        $colore = $conf['attivita']['colore_scoperto'];
                    }
                } else {
                    $colore = $conf['attivita']['colore_pubbliche'];
                }
                $r[] = [
                    'title'     =>  $attivita->nome. ', ' . $turno->nome,
                    'id'        =>  $turno->id,
                    'start'     =>  $turno->inizio()->toJSON(),
                    'end'       =>  $turno->fine()->toJSON(),
                    'color'     =>  '#' . $colore,
                    'url'       =>  '?p=attivita.scheda&id=' . $attivita->id . '&turno=' . $turno->id .'#'. $turno->id
                ];
            }
            return $r;
        }
        
        public function api_geocoding() {
            $this->richiedi(['query']);
            $g = new Geocoder($this->par['query']);
            return $g->risultati;
        }
        
        public function api_me() {
            $this->richiediLogin();
            $me = $this->sessione->utente();
            $r = [];
            $r['anagrafica'] = [
                'nome'          =>  $me->nome,
                'cognome'       =>  $me->cognome,
                'codiceFiscale' =>  $me->codiceFiscale,
                'email'         =>  $me->email
            ];
            $r['appartenenze'] = [];
            foreach ( $me->appartenenze() as $app ) {
                $r['appartenenze'][] = [
                    'id'        =>  $app->id,
                    'comitato'  =>  [
                        'id'    =>  $app->comitato()->id,
                        'nome'  =>  $app->comitato()->nome
                    ],
                    'inizio'    =>  $app->inizio()->toJSON(),
                    'fine'      =>  $app->fine()->toJSON(),
                    'stato'     =>  [
                        'id'    =>  $app->stato,
                        'nome'  =>  $conf['membro'][$app->stato]
                    ],
                    'attuale'   =>  $app->attuale()
                ];
            }
            
            return $r;
        }
        
        public function api_comitati() {
            $r = [];
            foreach ( Nazionale::elenco() as $n ) {
                $r[] = $n->toJSON();
            }
            return $r;
        }
        

        public function api_autorizza() {
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
            return $aut;
        }
        
        public function api_scansione() {
            $this->richiediLogin();
            $this->richiedi(['code']);
            $a = Volontario::by('codiceFiscale', $this->par['code']);
            if (!$a) { return null; }
            return [
                'nomeCompleto'  =>  $a->nomeCompleto(),
                'comitato'      =>  $a->unComitato()->nomeCompleto()
            ];
        }

        public function api_area_cancella() {
            $this->richiediLogin();
            $this->richiedi(['id']);
            $area = Area::id($this->par['id']);
            if ( $area->attivita() ) {
                throw new Errore(9050);
            }
            $area->cancella();
            return true;
        }

        public function api_volontari_cerca() {
            $this->richiediLogin();
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

            $me = $this->sessione->utente();
            $r->comitati = array_merge(
                // Dominio di ricerca
                $me->comitatiApp([
                    APP_PRESIDENTE,
                    APP_SOCI,
                    APP_OBIETTIVO
                ])
            );

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
        
}
