<?php

/*
 * ©2012 Croce Rossa Italiana
 * 
 */

class DonazioneMerito extends Entita {
    
    public static
        $_t     = 'donazioni_merito',
        $_dt    = null;
        
    use EntitaCache;
    
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
}
