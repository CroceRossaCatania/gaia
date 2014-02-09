<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Nazionale extends GeoPolitica {
        
    protected static
        $_t  = 'nazionali',
        $_dt = 'datiNazionali';

    public static 
        $_ESTENSIONE = EST_NAZIONALE;

    public function nomeCompleto() {
        return $this->nome;
    }

    public function estensione() {
        $r = [];
        foreach  ( $this->regionali() as $l ) {
            $r = array_merge($l->estensione(), $r);
        }
        return array_unique($r);
    }

    public function figli() {
        return $this->regionali();
    }

    public function superiore() {
        return false;
    }
    
    public function regionali() {
        return Regionale::filtra([
            ['nazionale',  $this->id]
        ], 'nome ASC');
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

    public function modificabileDa(Utente $u) {
        if ($altroUtente->admin()) {
            return true;
        }
        if ($this->unPresidente()->id == $u->id) {
            return true;
        }
        return false;
    }
    
}