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
        ], 'nome ASC');
    }
    
    public function regionale() {
        return Regionale::id($this->regionale);
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
            'indirizzo' =>  $this->formattato,
            'telefono'  =>  $this->telefono,
            'email'     =>  $this->email,
            'coordinate'=>  $this->coordinate(),
            'comitati'  =>  $locali,
            'id'        =>  $this->id
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
            $r[] = $k[0];
        }
        return $r;
    }

    public function piva($inTesto = false) {
        $piva = $this->piva;
        if ($this->nome == "Comitato Provinciale di Trento"
            or $this->nome == "Comitato Provinciale di Bolzano")
            $piva = PIVA;
        if ($inTesto && $piva) {
            return "P.IVA: {$piva}";
        }
        return $piva;
    }

    public function cf($inTesto = false) {
        $cf = $this->cf;
        if ($this->nome == "Comitato Provinciale di Trento"
            or $this->nome == "Comitato Provinciale di Bolzano")
            $cf = CF;
        if ($inTesto && $cf) {
            return "P.IVA: {$cf}";
        }
        return $cf;
    }

    public function privato() {
        if ($this->nome == "Comitato Provinciale di Trento"
            or $this->nome == "Comitato Provinciale di Bolzano")
            return false;
        return true;
    }

}