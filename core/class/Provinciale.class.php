<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Provinciale extends GeoEntita {
        
    protected static
        $_t  = 'provinciali',
        $_dt = 'datiComitati';

    public function locali() {
        return Locale::filtra([
            ['provinciale',  $this->id]
        ]);
    }
    
    public function regionale() {
        return new Regionale($this->regionale);
    }
    
    public function nazionale() {
        return $this->regionale()->nazionale();
    }
}