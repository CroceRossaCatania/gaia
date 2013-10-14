<?php

class Gruppo extends Entita {
        
    protected static
        $_t  = 'gruppi',
        $_dt = null;
    
    public function comitato() {
        return GeoPolitica::daOid($this->comitato);
    }
    
    public function referente() {
        return new Volontario($this->referente);
    }
    
    public function appartenenze() {
        return AppartenenzaGruppo::filtra([
            ['gruppo',  $this->id]
        ]);
    }
    
    public function membri() {
        $r = [];
        foreach ( $this->appartenenzeAttuali() as $a ) {
            $r[] = $a->volontario();
        }
        return $r;
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
    
    public function cancella() {
        foreach ( $this->appartenenze() as $app ) {
            $app->cancella();
        }
        parent::cancella();
    }

    public function estensione() {
        return $this->estensione;
    }
    
}