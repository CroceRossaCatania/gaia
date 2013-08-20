<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Attivita extends GeoEntita {
        
    protected static
        $_t  = 'attivita',
        $_dt = 'dettagliAttivita';

    public function comitato() {
        if ( $this->comitato ) {
            return new Comitato($this->comitato);
        } else {
            return false;
        }
    }

    public function area() {
        return new Area($this->area);
    }
    
    public function referente() {
        if ( $this->referente ) {
            return new Volontario($this->referente);
        } else {
            return null;
        }
    }
    
    public function turni() {
        return Turno::filtra([
            ['attivita',    $this->id]
        ], 'inizio ASC, nome ASC');
    }
    
    public function turniScoperti() {
        $t = [];
        foreach ( $this->turni() as $_t ) {
            if ( $_t->scoperto() ) {
                $t[] = $_t;
            }
        }
        return $t;
    }
    
    public function cancella() {
        foreach ( $this->turni() as $t ) {
            $t->cancella();
        }
        parent::cancella();
    }
    
    public function linkMappa() {
        $n = urlencode($this->luogo);
        $c = $this->coordinate();
        $c = $c[0] . ',' . $c[1];
        return "http://maps.google.com/?q={$n}@{$c}";
    }
    
    public function modificabileDa(Utente $u) {
        return (bool) (
                $u->id == $this->referente
            ||  in_array($this->area, $u->areeDiCompetenza())
        );
    }
    
    public function puoPartecipare($v) {
        if (!$v) { return true; }
        if ( $this->referente == $v->id || $v->admin() || $v->presiede($this->comitato()) ) {
            return true;
        }
        switch ( $this->visibilita ) {
            case ATT_VIS_UNITA:
                return (bool) $this->comitato()->haMembro($v);
                break;
            case ATT_VIS_LOCALE:
                return (bool) ($this->comitato()->locale == $v->unComitato()->locale);
                break;
            case ATT_VIS_PROVINCIALE:
                return (bool) ($this->comitato()->locale()->provinciale == $v->unComitato()->locale()->provinciale);
                break;
            case ATT_VIS_VOLONTARI:
                return (bool) $v->unComitato();
                break;
            case ATT_VIS_PUBBLICA:
                return true;
                break;
        }
        return false;
    }
    
    public function bozza() {
        return (bool) ($this->stato == ATT_STATO_BOZZA);
    }
    
    public function commenti ( $numero = 0 ) {
        $numero = (int) $numero;
        if ( $numero ) {
            $limit = "LIMIT 0, $numero";
        } else {
            $limit = '';
        }
        return Commento::filtra([
            ['attivita',    $this->id],
            ['upCommento',  0]
        ], "tCommenta DESC $limit");
    }
    
    public function turniFuturi() {
        $r = [];
        foreach ( $this->turni() as $t ) {
            if ( $t->futuro() ) {
                $r[] = $t;
            }
        }
        return $r;
    }
    
    public function volontariFuturi() {
        $r = [];
        foreach ( $this->turniFuturi() as $t ) {
            $r = array_merge($r, $t->volontari());
        }
        $r = array_unique($r);
        return $r;
    }
    
    public static function elencoMappa() {
        global $db;
        $q = $db->prepare("
            SELECT
                attivita.id
            FROM
                attivita, turni
            WHERE
                attivita.stato = :stato
            AND
                attivita.luogo  IS NOT NULL
            AND
                turni.attivita = attivita.id
            AND
                turni.fine    >= :ora
            AND
                turni.inizio <= :ora2");
        $q->bindValue(':ora', time());
        $q->bindValue(':ora2', time()+1209600);
        $q->bindValue(':stato', ATT_STATO_OK);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Attivita($k[0]);
        }
        return $r;
    }
    
}