<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Autorizzazione extends Entita {
        
    protected static
        $_t  = 'autorizzazioni',
        $_dt = null;

    public function partecipazione() {
        return new Partecipazione($this->partecipazione);
    }
    
    public function volontario() {
        return new Volontario($this->volontario);
    }
    
    public function aggiorna( $t = AUT_OK ) {
        global $sessione;
        $u = $sessione->utente();
        $this->pFirma = $u->id;
        $this->tFirma = time();
        $this->partecipazione()->aggiornaStato();
    }
    
    public function firmatario() {
        if ( $this->pFirma ) {
            return new Utente($this->pFirma);
        } else {
            return false;
        }
    }
    
    public function concedi() {
        return $this->aggiorna(AUT_OK);
    }
    
    public function nega() {
        return $this->aggiorna(AUT_NO);
    }
    
    public function richiedi() {
        $this->timestamp = time();
        return $this->aggiorna(AUT_PENDING);
    }
    
}