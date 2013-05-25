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
	
	public function __construct( $sessione = null ) {
            global $db;
            $this->db = $db;
            $this->sessione = new Sessione($sessione);
	}
	
	public function esegui( $azione = 'welcome' ) {
            if (empty($azione)) { $azione = 'welcome'; }
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
            $u = new Utente($this->par['id']);
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
            $r = [];
            foreach  ( $cA as $turno ) {
                $attivita = $turno->attivita();
                if ( !$attivita->puoPartecipare($this->sessione->utente()) ) {
                    continue;
                }
                $r[] = [
                    'title'     =>  $attivita->nome. ', ' . $turno->nome,
                    'id'        =>  $turno->id,
                    'start'     =>  $turno->inizio()->toJSON(),
                    'end'       =>  $turno->fine()->toJSON(),
                    'color'     =>  '#' . $attivita->comitato()->colore(),
                    'url'       =>  '?p=attivita.scheda&id=' . $attivita->id . '&turno=' . $turno->id
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
        
        public function api_cercaVolontario() {
            $this->richiedi(['query']);
            $me = $this->sessione->utente();
            $comitati = array_merge($me->comitatiDiCompetenza(), $me->comitati());
            $comitati = array_unique($comitati);
            $comitati = implode(', ', $comitati);
            $query = str_replace("'", "\'", $this->par['query']);
            $q = "SELECT
                    anagrafica.id
                  FROM
                    anagrafica, appartenenza
                  WHERE
                    anagrafica.id = appartenenza.volontario
                  AND
                    (appartenenza.fine = 0 OR appartenenza.fine IS NULL OR appartenenza.fine > :ora)
                  AND 
                    appartenenza.stato >= :app
                  AND
                    ( (
                        nome    LIKE '%$query%'
                      OR
                        cognome LIKE '%$query%'
                      
                    ) OR
                        (MATCH (anagrafica.nome, anagrafica.cognome)  AGAINST ('$query'))
                     )
                  AND
                    appartenenza.comitato IN ($comitati)
                  ORDER BY
                    (MATCH (anagrafica.nome, anagrafica.cognome)  AGAINST ('$query')) DESC, anagrafica.nome, anagrafica.cognome
                  LIMIT
                    0, 30";
            //var_dump($q);
            $q = $this->db->prepare($q);
            $q->bindValue(':ora', time());
            $q->bindValue(':app', MEMBRO_VOLONTARIO);
            $q->execute();
            $r = [];
            while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
                $v = new Volontario($k[0]);
                $c = $v->unComitato();
                $r[] = [
                    'id'        =>  $v->id,
                    'nome'      =>  str_replace("'", '`', $v->nomeCompleto()),
                    'comitato'  =>  [
                        'id'    => $c->id,
                        'nome'  => $c->nome
                    ]
                ];
            }
            return $r;
        }
        
        public function api_autorizza() {
            $this->richiedi(['id']);
            $this->richiediLogin();
            $aut = new Autorizzazione($this->par['id']);
            if ( $aut->stato == AUT_PENDING ) {
                
                $turno = $aut->partecipazione()->turno();
                $attivita = $turno->attivita();
                
                if ( $this->par['aut'] ) {
                    $aut->concedi();
                    
                    
                    $m = new Email('autorizzazioneConcessa', "Autorizzazione CONCESSA: {$attivita->nome}, {$turno->nome}" );
                    $m->a = $aut->partecipazione()->volontario();
                    $m->_NOME       = $aut->partecipazione()->volontario()->nome;
                    $m->_ATTIVITA   = $attivita->nome;
                    $m->_TURNO      = $turno->nome;
                    $m->_DATA      = $turno->inizio()->format('d-m-Y H:i');
                    $m->_LUOGO     = $attivita->luogo;
                    $m->_REFERENTE   = $attivita->referente()->nomeCompleto();
                    $m->_CELLREFERENTE = $attivita->referente()->cellulare();
                    $m->invia();
                    
                    
                } else {
                    $aut->nega();
                                        
                    $m = new Email('autorizzazioneNegata', "Autorizzazione NEGATA: {$attivita->nome}, {$turno->nome}" );
                    $m->a = $aut->partecipazione()->volontario();
                    $m->_NOME       = $aut->partecipazione()->volontario()->nome;
                    $m->_ATTIVITA   = $attivita->nome;
                    $m->_TURNO      = $turno->nome;
                    $m->_DATA      = $turno->inizio()->format('d-m-Y H:i');
                    $m->_LUOGO     = $attivita->luogo;
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
}