<?php

/*
 * ©2014 Croce Rossa Italiana
 */

class Like extends Entita {
    
    protected static
        $_t  = 'mipiace',
        $_dt = null;
        
    /**
     * Ottiene il volontario collegato all'oggetto like
     * @return Volontario
     */
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    /**
     * Ottiene quando apposto il like
     * @return DT
     */ 
    public function quando() {
        return DT::daTimestamp($this->timestamp);
    }
     
}