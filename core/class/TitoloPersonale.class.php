<?php

/*
 * ©2012 Croce Rossa Italiana
 * 
 */

class TitoloPersonale extends Entita {
    
    public static
        $_t     = 'titoliPersonali',
        $_dt    = null;
    
    public function confermato() {
        if ( $this->tipo != TITOLO_CRI || $this->tConferma ) {
            return true;
        } else {
            return false;
        }
    }
    
    public function titolo() {
        return new Titolo($this->titolo);
    }
    
    public function volontario() {
        return new Volontario($this->volontario);
    }
    
    public function pConferma() {
        return new Volontario($this->pConferma);
    }
    
    
    public function tConferma() {
        return DT::daTimestamp($this->tConferma);
    }
    
    public static function pendenti() {
        global $db;
        $q = $db->prepare("SELECT id FROM titoliPersonali WHERE tConferma IS NULL");
        $q->execute();
        $t = [];
        while ( $r = $q->fetch(PDO::FETCH_NUM) ) {
            $t[] = new TitoloPersonale($r[0]);
        }
        return $t;
    }
    
    public static function inScadenza($rangeTitoloMin, $rangeTitoloMax, $giorni = 15) {
        global $db;
        $q = $db->prepare("
            SELECT
                id
            FROM
                titoliPersonali
            WHERE
                titolo BETWEEN :rmin AND :rmax
            AND
                fine    >   :oggi
            AND
                fine    <=  :limite
         ");
        $oggi = time();
        $limite = strtotime("+$giorni days");
        $q->bindParam(':rmin', $rangeTitoloMin, PDO::PARAM_INT);
        $q->bindParam(':rmax', $rangeTitoloMax, PDO::PARAM_INT);
        $q->bindParam(':oggi', $oggi, PDO::PARAM_INT);
        $q->bindParam(':limite', $limite, PDO::PARAM_INT);
        $q->execute();
        $r = [];
        while ( $x = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new TitoloPersonale($x[0]);
        }
        return $r;
        
    }
    
}
