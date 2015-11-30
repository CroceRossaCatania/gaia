<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Nazionale extends GeoPolitica {
        
    protected static
        $_t  = 'nazionali',
        $_dt = 'datiNazionali';

    use EntitaCache;

    public static 
        $_ESTENSIONE = EST_NAZIONALE;

    public function nomeCompleto() {
        return $this->nome;
    }

    public function estensione($soloComitati = true) {
        $r = [];
        if(!$soloComitati) {
            $r[] = $this;
        }
        foreach  ( $this->regionali() as $l ) {
            $r = array_merge($l->estensione($soloComitati), $r);
        }
        return array_unique($r);
    }

    public function figli($mostraDisattivi = false) {
        return $this->regionali($mostraDisattivi);
    }

    public function superiore() {
        return false;
    }
    
    public function regionali($mostraDisattivi = false) {
        if ( $mostraDisattivi ) {
            return Regionale::filtra([
                ['nazionale',  $this->id],
            ], 'nome ASC');
        } else {
            return Regionale::filtra([
                ['nazionale',  $this->id],
                ['attivo',     1],
            ], 'nome ASC');
        }
    }
    
    public function toJSON() {
        $regionali = $this->regionali();
        foreach ( $regionali as &$regionale ) {
            $regionale = $regionale->toJSON();
        }
        return [
            'nome'          =>  $this->nome,
            'regionali'     =>  $regionali,
            'id'            =>  $this->id
        ];
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

    public function privato() {
        return false;
    }

    public function tesserini($stato=RICHIESTO) {
        global $db;
        $q = $db->prepare("
            SELECT 
                id 
            FROM
                tesserinoRichiesta
            WHERE 
                stato = :stato
            ");
        $q->bindValue(':stato', $stato);
        $r = $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = $k[0];
        }
        return count($r);
    }

    public static function fototessereNazionali($stato=FOTOTESSERA_OK) {
        global $db;
        $q = $db->prepare("
            SELECT 
                id 
            FROM
                fototessera
            WHERE
                stato = :stato
            ");
        $q->bindValue(':stato', $stato);
        $r = $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = $k[0];
        }
        return count($r);
    }
    
}
