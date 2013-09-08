<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Locale extends GeoPolitica {
        
    protected static
        $_t  = 'locali',
        $_dt = 'datiLocali';

    public static 
        $_ESTENSIONE = EST_LOCALE;

    
    public function nomeCompleto() {
        return $this->nome;
    }
    
    public function estensione() {
        return $this->comitati();
    }

    public function figli() {
        return $this->comitati();
    }

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
    
    public function toJSON() {
        $comitati = $this->comitati();
        foreach ( $comitati as &$comitato ) {
            $comitato = $comitato->toJSON();
        }
        return [
            'nome'  =>  $this->nome,
            'unita' =>  $comitati
        ];
    }

    /**
     * Ottiene l'unita' territoriale principale del comitato,
     * oppure null se questa non e' presente
     */
    public function principale() {
        $p = Comitato::filtra([
            ['locale',      $this->id],
            ['principale',  1]
        ]);
        if (!$p) { return false; }
        return $p[0];
    }
    
}