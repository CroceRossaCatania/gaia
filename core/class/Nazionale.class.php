<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Nazionale extends GeoEntita {
        
    protected static
        $_t  = 'nazionali',
        $_dt = 'datiComitati';

    public function regionali() {
        return Regionale::filtra([
            ['nazionale',  $this->id]
        ]);
    }
    
    
}