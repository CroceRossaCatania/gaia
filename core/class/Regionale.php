<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Regionale extends GeoPolitica {
        
    protected static
        $_t  = 'regionali',
        $_dt = 'datiRegionali';

    use EntitaCache;

    public static 
        $_ESTENSIONE = EST_REGIONALE;

    
    public function nomeCompleto() {
        return $this->nome;
    }

    public function estensione($soloComitati = true) {
        $r = [];
        if(!$soloComitati) {
            $r[] = $this;
        }
        foreach  ( $this->provinciali() as $l ) {
            $r = array_merge($l->estensione($soloComitati), $r);
        }
        return array_unique($r);
    }

    public function figli($mostraDisattivi = false) {
        return $this->provinciali($mostraDisattivi);
    }

    public function superiore() {
        return $this->nazionale();
    }
    
    public function provinciali($mostraDisattivi = false) {
        if ( $mostraDisattivi ) {
            return Provinciale::filtra([
                ['regionale',  $this->id]
            ], 'nome ASC');
        } else {
            return Provinciale::filtra([
                ['regionale',  $this->id],
                ['attivo',     1],
            ], 'nome ASC');
        }
    }
    
    public function nazionale() {
        return Nazionale::id($this->nazionale);
    }
    
        
    public function toJSON() {
        $provinciali = $this->provinciali();
        foreach ( $provinciali as &$provinciale ) {
            $provinciale = $provinciale->toJSON();
        }
        return [
            'nome'          =>  $this->nome,
            'indirizzo'     =>  $this->formattato,
            'telefono'      =>  $this->telefono,
            'email'         =>  $this->email,
            'coordinate'    =>  $this->coordinate(),
            'provinciali'   =>  $provinciali,
            'id'            =>  $this->id
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

    public function privato() {
        return false;
    }

    public function cf($inTesto = false) {
        $cf = CF;
        if ($inTesto) {
            return "C.F.: {$cf}";
        }
        return $cf;
    }

    public function piva($inTesto = false) {
        $piva = PIVA;
        if ($inTesto) {
            return "P.IVA: {$piva}";
        }
        return $piva;
    }

    public function tesserini($stato=RICHIESTO) {
        global $db;
        $q = $db->prepare("
            SELECT 
                id 
            FROM
                tesserinoRichiesta
            WHERE 
                struttura = :struttura
            AND
                stato = :stato
            ");
        $q->bindValue(':stato', $stato);
        $q->bindValue(':struttura', $this->oid());
        $r = $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = $k[0];
        }
        return count($r);
    }

}