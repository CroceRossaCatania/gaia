<?php

/*
 * ©2012 Croce Rossa Italiana
 * 
 */

class DonazioneMerito extends Entita {
    
    public static
        $_t     = 'donazioniMerito',
        $_dt    = null;

    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
}
