<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Delegato extends Entita {
    
    protected static
        $_t  = 'delegati',
        $_dt = null;
    
    public function volontario() {
        return Volontario::id($this->volontario);
    }

    public function comitato() {
        return GeoPolitica::daOid($this->comitato);
    }
    
    public function estensione() {
        return $this->comitato()->estensione();
    }

    public function attuale() {
	$ora = time();
        if (
	    ( !$this->fine || $this->fine > $ora )
	      && $this->inizio <= $ora ) {
            return true;
        } else {
            return false;
        }
    }
    
    public function inizio() {
        return DT::daTimestamp($this->inizio);
    }    
    
    public function fine() {
        return DT::daTimestamp($this->fine);
    }
    
    public function pConferma() {
        return Volontario::id($this->pConferma);
    }
    
}
