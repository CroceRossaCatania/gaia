<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Locale extends GeoEntita {
        
    protected static
        $_t  = 'locali',
        $_dt = 'datiLocali';

    public function comitati() {
        return Comitato::filtra([
            ['locale',  $this->id]
        ]);
    }
    
    public function provinciale() {
        return new Provinciale($this->provinciale);
    }
    
    public function regionale() {
        return $this->provinciale()->regionale();
    }
    
    public function nazionale() {
        return $this->provinciale()->regionale()->nazionale();
    }
    
}