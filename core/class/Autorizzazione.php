<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Autorizzazione extends Entita {
        
    protected static
        $_t  = 'autorizzazioni',
        $_dt = null;

    public function partecipazione() {
        return Partecipazione::id($this->partecipazione);
    }
    
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public function aggiorna( $t = AUT_OK ) {
        global $sessione;
        $u = $sessione->utente;
        $this->stato = (int) $t;
        $this->pFirma = $u;
        $this->tFirma = time();
        $this->partecipazione()->aggiornaStato();
    }
    
    public function firmatario() {
        if ( $this->pFirma ) {
            return Utente::id($this->pFirma);
        } else {
            return false;
        }
    }

    public function toJSON() {
        global $conf;
        return [
            'id'        =>  $this->id,
            'stato'     =>  [
                'id'        =>  (int) $this->stato,
                'nome'      =>  $conf['autorizzazione'][$this->stato]
            ],
            'volontario'=>  $this->volontario()->toJSON()
        ];
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
    
    public function tFirma() {
        return DT::daTimestamp($this->tFirma);
    }
    
    public function timestamp() {
        return DT::daTimestamp($this->timestamp);
    }
}