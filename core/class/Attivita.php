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
            return GeoPolitica::daOid($this->comitato);
        } else {
            return false;
        }
    }

    public function area() {
        return Area::id($this->area);
    }
    
    public function referente() {
        if ( $this->referente ) {
            return Volontario::id($this->referente);
        } else {
            return null;
        }
    }
    
    public function turni() {
        return Turno::filtra([
            ['attivita',    $this->id]
        ], 'inizio ASC, nome ASC');
    }
    
    public function turniFut(){
        global $db;
        $q = $db->prepare("
            SELECT
                id
            FROM
                turni
            WHERE
                attivita = :attivita
            AND
                fine > :ora
            ORDER BY
                inizio ASC");
        $q->bindValue(':ora', time());
        $q->bindParam(':attivita', $this);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Turno::id($k[0]);
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
    
    public function modificabileDa(Utente $u) {
        return (bool) (
                $u->id == $this->referente
            ||  in_array($this->area, $u->areeDiCompetenza())
            ||  in_array($this, $u->attivitaDiGestione())
        );
    }
    
    public function puoPartecipare($v) {
        if (!$v) { return true; }

        $geoComitato = GeoPolitica::daOid($this->comitato);
        if ( $this->referente == $v->id || $v->admin() || $geoComitato->unPresidente()->id == $v->id ) {
            return true;
        }
        switch ( $this->visibilita ) {
            case ATT_VIS_UNITA:
                return (bool) $geoComitato->contieneVolontario($v);
                break;
                
            case ATT_VIS_LOCALE:
                while(intval($geoComitato->_estensione()) < EST_LOCALE) {
                    $oid = $geoComitato->superiore()->oid();
                    $geoComitato = GeoPolitica::daOid($oid);
                }
                return (bool) $geoComitato->contieneVolontario($v);
                break;
            case ATT_VIS_PROVINCIALE:
                while(intval($geoComitato->_estensione()) < EST_PROVINCIALE) {
                    $oid = $geoComitato->superiore()->oid();
                    $geoComitato = GeoPolitica::daOid($oid);
                }
                return (bool) $geoComitato->contieneVolontario($v);
                break;
            case ATT_VIS_REGIONALE:
                while(intval($geoComitato->_estensione()) < EST_REGIONALE) {
                    $oid = $geoComitato->superiore()->oid();
                    $geoComitato = GeoPolitica::daOid($oid);
                }
                return (bool) $geoComitato->contieneVolontario($v);
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
            $r[] = Attivita::id($k[0]);
        }
        return $r;
    }

    public static function pulizia() {
        $eseguiti=0;
        $nAttivita = 0;
        $attivita = Attivita::elenco();
        foreach( $attivita as $a ){
            $comitato = $a->comitato();
            if( $comitato ){
                try {
                    $referente = $a->referente();
                } catch (Exception $e) {
                    $referente = $a->referente;
                    $comitato = $a->comitato();
                    $presidente = $comitato->unPresidente();
                    if ( !$presidente ) { 
                        $locale = $comitato->locale();
                        $presidente = $locale->unPresidente();
                    }
                    $autorizzazioni = Autorizzazione::filtra(['volontario', $referente]);
                    foreach ( $autorizzazioni as $autorizzazione ){
                        $m = Autorizzazione::id($autorizzazione);
                        $m->volontario = $presidente;
                    }
                    $att = Attivita::id($a);
                    $att->referente = $presidente;
                    $eseguiti++;
                    continue;
                }
                continue;
            }else{
                $turni = Turno::filtra([['attivita', $a]]);
                foreach( $turni as $turno ){
                    $partecipazioni = Partecipazione::filtra([['turno', $turno]]);
                    foreach( $partecipazioni as $partecipazione ){
                        $autorizzazioni = Autorizzazione::filtra(['partecipazione', $partecipazione]);
                        foreach( $autorizzazioni as $autorizzazione ){
                            $autorizzazione->cancella();
                        }
                        $partecipazione->cancella();
                    }
                    $turno->cancella();
                }
                $a->cancella();
                $nAttivita++;
            }
        }
    $t = $eseguiti + $nAttivita;
    return $t;
    }

    public function visibilitaMinima(GeoPolitica $g) {
        $livello = $g->_estensione();
        switch ($livello) {
            case EST_UNITA:         return ATT_VIS_UNITA;
                                    break;
            case EST_LOCALE:        return ATT_VIS_LOCALE;
                                    break;
            case EST_PROVINCIALE:   return ATT_VIS_PROVINCIALE;
                                    break;
            case EST_REGIONALE:     return ATT_VIS_REGIONALE;
                                    break;
            case EST_NAZIONALE:     return ATT_VIS_NAZIONALE;
                                    break;
        }
    }
    
}