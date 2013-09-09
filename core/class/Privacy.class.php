<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Privacy extends Entita {
        
    protected static
        $_t  = 'privacy',
        $_dt = null;
    
    public function volontario() {
        return new Volontario($this->id);
    }
    
}