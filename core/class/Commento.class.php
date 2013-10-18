<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Commento extends Entita {
    
    protected static
        $_t  = 'commenti',
        $_dt = null;
        
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public function autore() {
        return $this->volontario();
    }
        
    public function quando() {
        return DT::daTimestamp($this->tCommenta);
    }
    
    public function risposte() {
        return Commento::filtra([
            ['upCommento',  $this->id]
        ], 'tCommenta DESC');
    }
     
}