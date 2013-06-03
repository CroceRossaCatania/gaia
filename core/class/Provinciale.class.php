<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Provinciale extends GeoPolitica {
        
    protected static
        $_t  = 'provinciali',
        $_dt = 'datiProvinciali';
    
    public function nomeCompleto() {
        return $this->nome;
    }
    
    public function estensione() {
        $r = [];
        foreach  ( $this->locali() as $l ) {
            $r = array_merge($l->estensione(), $r);
        }
        return array_unique($r);
    }

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
    
    public function toJSON() {
        $locali = $this->locali();
        foreach ( $locali as &$locale ) {
            $locale = $locale->toJSON();
        }
        return [
            'nome'      =>  $this->nome,
            'comitati'  =>  $locali
        ]; 
    }
}