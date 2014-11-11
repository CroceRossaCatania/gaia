<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class RichiestaTurno extends Entita {
    
    protected static
        $_t  = 'richiesteTurni',
        $_dt = null;

    use EntitaCache;
        
    public function elementi(){
        return ElementoRichiesta::filtra([
            ['richiesta', $this->id]
        ]);
    } 
    
    public function turno() {
        return Turno::id($this->turno);
    }
        
        
}