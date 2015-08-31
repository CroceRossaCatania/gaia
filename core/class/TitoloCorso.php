<?php

/*
 * ©2012 Croce Rossa Italiana
 * 
 */

class TitoloCorso extends Entita {
    
    protected static
        $_t     = 'titoliCorsi',
        $_dt    = null;

    use EntitaCache;
    
    public static function cerca($stringa) {
        return self::cercaFulltext($stringa, ['nome'], 20);
    }

    public function titolo() {
        return Titolo::id($this->titolo);
    }
    
    public function cancella() {
        parent::cancella();
    }
    
    public function inScadenza(){
        $now = time();
        
        if ($this->valido() && (intval($this->fine, 10) - $now) <=  2629743) {
            return true;
        }
        
        return false;
    }
    
    public function valido(){
        $now = time();
        
        if (intval($this->inizio, 10) < $now && intval($this->fine, 10) > $now){
            return true;
        }
        
        return false;
    }

}
