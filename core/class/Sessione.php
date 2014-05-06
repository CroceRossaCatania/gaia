<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Sessione extends REntita {
    
    
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
    
    public function touch() {
        global $conf;
        $this->azione = time();
        $this->impostaScadenza($conf['sessioni']['durata']);
    }
    
    public function valida() {
        // Mantenuto per retrocompatibilita'.
        // Se esiste, infatti, la sessione e' valida.
        return true;
    }
    
    public function toJSON () {
        global $conf;
        if ( $this->utente ) {
            $u = $this->utente()->toJSON();
        } else {
            $u = false;
        }
        return [
            'id'            =>  $this->id,
            'identificato'  =>  (bool) $u,
            'utente'        =>  $u,
            'scadenza'       =>  DT::daTimestamp(                
                $this->azione + $conf['sessioni']['durata'] 
            )->toJSON()
        ];
    }
    
}