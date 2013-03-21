<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Turno extends Entita {
    
    protected static
        $_t  = 'turni',
        $_dt = null;
    
    public function attivita() {
        return new Attivita($this->attivita);
    }

    public function inizio() {
    	return new DT('@'. $this->inizio);
    }

    public function fine() {
    	return new DT('@'. $this->fine);
    }
    
    public function partecipazioni() {
        return Partecipazione::filtra([
            ['turno',   $this->id]
        ]);
    }
    
    public static function neltempo(DT $inizio, DT $fine) {
        global $db;
        $q = "
            SELECT
                id
            FROM
                turni
            WHERE
                fine <= :fine
            AND
                inizio >= :inizio
            ORDER BY
                inizio ASC";
        $q = $db->prepare($q);
        $inizio = $inizio->getTimestamp();
        $fine   = $fine->getTimestamp();
        $q->bindParam(':fine', $fine);
        $q->bindParam(':inizio', $inizio);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Turno($k[0]);
        }
        return $r;
    }

}