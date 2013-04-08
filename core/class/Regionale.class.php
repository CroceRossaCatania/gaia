<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Regionale extends GeoEntita {
        
    protected static
        $_t  = 'regionali',
        $_dt = 'datiComitati';

    public function provinciali() {
        return Provinciale::filtra([
            ['regionale',  $this->id]
        ]);
    }
    
    public function nazionale() {
        return new Nazionale($this->nazionale);
    }
    
}