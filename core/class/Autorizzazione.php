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
    
    /**
     * Aggiorna lo stato dell'Autorizzazione.
     *
     * @param int $t        Nuovo stato, uno da AUT_OK, AUT_NO, ...
     * @param Utente|false  Firmatario. Opzionale: se vuoto, $me.
     */
    public function aggiorna( $t = AUT_OK, $firmatario = false ) {
        if ( !$firmatario ) {
            global $sessione;
            $firmatario = $sessione->utente();
        }
        $this->stato = (int) $t;
        $this->pFirma = $firmatario->id;
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
    
    public function concedi( $firmatario = false ) {
        return $this->aggiorna(AUT_OK, $firmatario);
    }
    
    public function nega( $firmatario = false ) {
        return $this->aggiorna(AUT_NO, $firmatario);
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