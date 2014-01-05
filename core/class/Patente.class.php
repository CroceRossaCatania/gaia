<?php

/*
 * ©2013 Croce Rossa Italiana
 * 
 */

class Patente extends Entita {
    
    public static
        $_t     = 'patenti',
        $_dt    = 'dettagliPatenti';
    
    public function confermato() {
        return (bool) $this->tConferma;
    }
    
    public function patente() {
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
    
    /*
     * Patenti in attesa di approvazione
     * @return array patenti in attesa di approvazione
     */
    public static function pendenti() {
        global $db;
        $q = $db->prepare("SELECT id FROM patenti WHERE tConferma IS NULL");
        $q->execute();
        $t = [];
        while ( $r = $q->fetch(PDO::FETCH_NUM) ) {
            $t[] = Patente::id($r[0]);
        }
        return $t;
    }

    /*
     * Patenti in scadenza
     * @return array patenti in scadenza nei prossimi 15 giorni
     */
    public static function inScadenza($tipo=PATENTE_CRI, $giorni = 15) {
        global $db;
        $q = $db->prepare("
            SELECT
                id
            FROM
                patenti
            WHERE
                tipo    =   :tipo
            AND
                fine    >   :oggi
            AND
                fine    <=  :limite
         ");
        $oggi = time();
        $limite = strtotime("+$giorni days");
        $q->bindParam(':tipo', $tipo);
        $q->bindParam(':oggi', $oggi, PDO::PARAM_INT);
        $q->bindParam(':limite', $limite, PDO::PARAM_INT);
        $q->execute();
        $r = [];
        while ( $x = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = Patente::id($x[0]);
        }
        return $r;
        
    }
    
    /*
     * Patenti in scadenza di un volontario specificato
     * @return array patenti in scadenza nei prossimi 15 giorni di un volontario specificato
     */
    public static function scadenzame($tipo=PATENTE_CRI, $volontario) {
        global $db;
        $q = $db->prepare("
            SELECT 
                id 
            FROM 
                patenti 
            WHERE 
                volontario = :volontario 
            AND
                tipo = :tipo
            AND 
                fine > :oggi 
            AND
                fine <= :limite
                ");
        $oggi = time();
        $limite = strtotime("+15 days");
        $q->bindParam(':oggi', $oggi, PDO::PARAM_INT);
        $q->bindParam(':tipo', $tipo);
        $q->bindParam(':limite', $limite, PDO::PARAM_INT);
        $q->bindParam(':volontario', $volontario, PDO::PARAM_INT);
        $q->execute();
        $t = [];
        while ( $r = $q->fetch(PDO::FETCH_NUM) ) {
            $t[] = Patente::id($r[0]);
        }
        return $t;
    }
    
}
