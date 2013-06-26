<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Quota extends Entita {
    
    protected static
        $_t  = 'quote',
        $_dt = null;
    
    public function volontario() {
        return new Volontario($this->appartenenza()->volontario());
    }
    
    public function appartenenza() {
        return new Appartenenza($this->appartenenza);
    }
    
    public function comitato() {
        return $this->appartenenza()->comitato();
    }
    
    
}
