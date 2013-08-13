<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Estensione extends Entita {
    
    protected static
        $_t  = 'estensioni',
        $_dt = null;
    
    public function volontario() {
        return new Volontario($this->volontario);
    }
    
    public function appartenenza() {
        return new Appartenenza($this->appartenenza);
    }
    

    public function comitato() {
        return $this->appartenenza()->comitato();
    }
    
    public function presaInCarico() {
        if ( $this->protNumero && $this->protData ) {
            return true;
        } else {
            return false;
        }
    }
        
    public function rispondi($risposta = EST_OK, $motivo = null) {
        global $sessione;
        $this->stato = $risposta;
        $this->pConferma = $sessione->utente()->id;
        $this->tConferma = time();
        $this->negazione = $motivo;
    }
    
    public function concedi() {
        $this->rispondi(EST_OK);
    }
    
    public function nega($motivo) {
        $this->rispondi(EST_NEGATA, $motivo);
    }
    
    public function auto() {
        $this->risposta = EST_AUTO;
        $this->tConferma = time();
    }

    public function termina() {
        $this->timestamp = time();
        $this->stato = EST_CONCLUSA;
        $app = new Appartenenza($this->appartenenza);
        $app->stato = MEMBRO_EST_TERMINATA;
        $app->fine = time();
    }
        
}
