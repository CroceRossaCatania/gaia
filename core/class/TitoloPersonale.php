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
        return (bool) $this->tConferma;
    }
    
    public function titolo() {
        return Titolo::id($this->titolo);
    }
    
    public function volontario() {
        return Volontario::id($this->volontario);
    }
    
    public function pConferma() {
        return Volontario::id($this->pConferma);
    }
    
    
    public function tConferma() {
        return DT::daTimestamp($this->tConferma);
    }

    public function inizio() {
            return DT::daTimestamp($this->inizio);
    }

    public function fine() {
            return DT::daTimestamp($this->fine);
    }
    
    public static function pendenti() {
        global $db;
        $q = $db->prepare("SELECT id FROM titoliPersonali WHERE tConferma IS NULL");
        $q->execute();
        $t = [];
        while ( $r = $q->fetch(PDO::FETCH_NUM) ) {
            $t[] = TitoloPersonale::id($r[0]);
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
            $r[] = TitoloPersonale::id($x[0]);
        }
        return $r;
        
    }
    
    public static function scadenzame($volontario) {
        global $db;
        $q = $db->prepare("
            SELECT 
                id 
            FROM 
                titoliPersonali 
            WHERE 
                volontario = :volontario 
            AND
                titolo BETWEEN :min AND :max
            AND 
                fine > :oggi 
            AND
                fine <= :limite
                ");
        $oggi = time();
        $limite = strtotime("+15 days");
        $pat1 = 2700;
        $pat2 = 2709;
        $q->bindParam(':oggi', $oggi, PDO::PARAM_INT);
        $q->bindParam(':min', $pat1, PDO::PARAM_INT);
        $q->bindParam(':max', $pat2, PDO::PARAM_INT);
        $q->bindParam(':limite', $limite, PDO::PARAM_INT);
        $q->bindParam(':volontario', $volontario, PDO::PARAM_INT);
        $q->execute();
        $t = [];
        while ( $r = $q->fetch(PDO::FETCH_NUM) ) {
            $t[] = TitoloPersonale::id($r[0]);
        }
        return $t;
    }
    
}
