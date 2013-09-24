<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Regionale extends GeoPolitica {
        
    protected static
        $_t  = 'regionali',
        $_dt = 'datiRegionali';

    public static 
        $_ESTENSIONE = EST_REGIONALE;

    
    public function nomeCompleto() {
        return $this->nome;
    }

    public function estensione() {
        $r = [];
        foreach  ( $this->provinciali() as $l ) {
            $r = array_merge($l->estensione(), $r);
        }
        return array_unique($r);
    }

    public function figli() {
        return $this->provinciali();
    }

    public function superiore() {
        return $this->nazionale();
    }
    
    public function provinciali() {
        return Provinciale::filtra([
            ['regionale',  $this->id]
        ]);
    }
    
    public function nazionale() {
        return new Nazionale($this->nazionale);
    }
    
        
    public function toJSON() {
        $provinciali = $this->provinciali();
        foreach ( $provinciali as &$provinciale ) {
            $provinciale = $provinciale->toJSON();
        }
        return [
            'nome'          =>  $this->nome,
            'provinciali'   =>  $provinciali
        ];
    }
    
    public static function regionaliNull() {
        global $db;
        $q = $db->prepare("
            SELECT 
                id 
            FROM
                regionali
            WHERE 
                nome IS NULL
            ");
        $r = $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = $k[0];
        }
        return $r;
    }
}