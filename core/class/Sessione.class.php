<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Sessione extends Entita {
    
    protected static
            $_t  = 'sessioni',
            $_dt = 'datiSessione';
    
    public function __construct ( $id = null ) {
        try {
           /* Carica */
           parent::__construct($id);
        } catch ( Errore $e ) {
           /* Se non esiste crea */
           $this->__construct(null);
        }
        if (!$this->valida()) {
            /* Se non valida cancella */
            $this->utente = null;
        }
        $this->touch();
    }

    
    public function utente() {
        if ( $this->utente ) {
            return new Utente($this->utente);
        } else {
            return null;
        }
    }
    
    public function logout() {
        $this->utente = null;
    }
    
    protected function generaId() {
        do {
            $n = sha1( microtime() . rand(100, 999) ) . rand(100, 999);
        } while (self::_esiste($n));
        return $n;
    }
    
    public function touch() {
        $this->azione = time();
    }
    
    public function valida() {
        global $conf;
        if ( $this->azione + $conf['sessioni']['durata'] < time() ) {
            /* $this->cancella(); */
            return false;
        } else {
            return true;
        }
    }
    
    public function toJSON () {
        if ( $this->utente ) {
            $u = $this->utente()->toJSON();
            $s = 'logged';
        } else {
            $u = false;
            $s = 'anonymous';
        }
        return [
            'id'        =>  $this->id,
            'status'    =>  $s,
            'user'      =>  $u,
            'expires'   =>  new DateTime(
                    '@' . (
                        $this->azione + $conf['sessioni']['durata']
                    )
            )
        ];
    }
    
}