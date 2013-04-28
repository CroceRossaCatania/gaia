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
        $q = $this->db->prepare("
            SELECT      id
            FROM        turni
            WHERE       attivita = :id
            ORDER BY    inizio DESC,
                        nome   ASC");
        $q->bindParam(':id',    $this->id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Turno($k[0]);
        }
        return $r;
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
            ||  in_array($u->areeDiCompetenza( $this->area ))
        );
    }
    
    public function puoPartecipare(Utente $v) {
        if ( $this->referente == $v->id || $v->admin || $v->presiede($this->comitato()) ) {
            return true;
        }
        switch ( $this->visibilita ) {
            case ATT_VIS_UNITA:
                return (bool) $this->comitato()->haMembro($v);
                break;
            case ATT_VIS_LOCALE:
                return (bool) $this->comitato()->locale == $v->unComitato()->locale;
                break;
            case ATT_VIS_PROVINCIALE:
                return (bool) $this->comitato()->locale()->provinciale == $v->unComitato()->locale()->provinciale;
                break;
            case ATT_VIS_VOLONTARI:
                return (bool) $v->unComitato();
                break;
            case ATT_VIS_PUBBLICA:
                return true;
                break;
        }
    }
    
    public function bozza() {
        return (bool) ($this->stato == ATT_STATO_BOZZA);
    }
}