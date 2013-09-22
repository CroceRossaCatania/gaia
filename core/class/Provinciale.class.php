<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Provinciale extends GeoPolitica {
        
    protected static
        $_t  = 'provinciali',
        $_dt = 'datiProvinciali';
    
    public static 
        $_ESTENSIONE = EST_PROVINCIALE;

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

    public function figli() {
        return $this->locali();
    }

    public function superiore() {
        return $this->regionale();
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

    public static function provincialiNull() {
        global $db;
        $q = $db->prepare("
            SELECT 
                id 
            FROM
                provinciali
            WHERE 
                nome IS NULL
            ");
        $r = $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Provinciale($k[0]);
        }
        return $r;
    }
}