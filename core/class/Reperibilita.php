<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Reperibilita extends Entita {
    
    protected static
        $_t  = 'reperibilita',
        $_dt = null;

    use EntitaCache;
    
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public function comitato() {
        return Comitato::id($this->comitato);
    }
    
    public function attuale() {
        if ( !$this->fine || $this->fine > time() ) {
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
    
}