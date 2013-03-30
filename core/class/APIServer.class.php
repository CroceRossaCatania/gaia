<?php

/*
 * ©2012 Croce Rossa Italiana
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
            $inizio = new DT($this->par['inizio']);
            $fine   = new DT($this->par['fine']);
            /*$cA = $this->sessione->utente()->calendario($inizio, $fine);*/
            $cA = Turno::neltempo($inizio, $fine);
            $r = [];
            foreach  ( $cA as $turno ) {
                $attivita = $turno->attivita();
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
}