<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Coturno extends Entita {
    
    protected static
        $_t  = 'coturni',
        $_dt = null;

    use EntitaCache;
    
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public function monta() {
        $this->stato = CO_MONTA;
        $this->tMonta  = time();
    }
    
    public function smonta() {
        $this->stato = CO_SMONTA;
        $this->tSmonta  = time();
    }
     
}