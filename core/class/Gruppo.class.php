<?php

class Gruppo extends Entita {
        
    protected static
        $_t  = 'gruppi',
        $_dt = null;
    
    public function comitato() {
        return GeoPolitica::daOid($this->comitato);
    }
    
    public function referente() {
        if(!$this->referente){
            return false;
        }
        return Volontario::id($this->referente);
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

    public function modificabileDa(Utente $utente) {
        $id = $utente->id;
        return (bool) (
            $this->referente()->id == $id
            or $utente->admin()
            or in_array($this, $utente->gruppiDiCompetenza())
            ); 
    }
    
    public function attivita() {
        return Attivita::id($this->attivita);
    }
}