<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Quota extends Entita {
    
    protected static
        $_t  = 'quote',
        $_dt = null;
    
    public function volontario() {
        return Volontario::id($this->appartenenza()->volontario());
    }
    
    public function appartenenza() {
        return Appartenenza::id($this->appartenenza);
    }
    
    public function comitato() {
        return $this->appartenenza()->comitato();
    }
    
    public function conferma() {
        return Volontario::id($this->pConferma);
    }
    
}
