<?php

class Gruppo extends Entita {
        
    protected static
        $_t  = 'gruppi',
        $_dt = null;
    
    public function comitato() {
        return new Comitato($this->comitato);
    }
    
    public function referente() {
        return new Volontario($this->referente);
    }
    
    public function appartenenze() {
        return AppartenenzaGruppo::filtra([
            ['gruppo',  $this->id]
        ]);
    }
    
    public function appartenenzeAttuali() {
        $app = $this->appartenenze();
        $t = [];
        foreach ( $app as $pp ) {
            if ( $pp->attuale() ) {
                $t[] = $pp;
            }
        }
        return $t;
    }
    
}