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
    	return DT::daTimestamp($this->inizio);
    }

    public function fine() {
    	return DT::daTimestamp($this->fine);
    }
    
    public function partecipazioni() {
        return Partecipazione::filtra([
            ['turno',   $this->id]
        ]);
    }
    
    public function cancella() {
        foreach ( $this->partecipazioni() as $part ) {
            $part->cancella();
        }
        parent::cancella();
    }
    
    public function durata() {
        return $this->inizio()->diff($this->fine());
    }
    
    public function partecipazione(Utente $v) {
        $p = Partecipazione::filtra([
            ['turno',       $this->id],
            ['volontario',  $v->id]
        ]);
        if ( $p ) {
            return $p[0];
        } else {
            return null;
        }
    }
    
    public function partecipa(Volontario $v) {
        return (bool) $this->partecipazione($v);
    }
    
    public static function neltempo(DT $inizio, DT $fine) {
        global $db;
        $q = "
            SELECT
                turni.id
            FROM
                turni, attivita
            WHERE
                turni.fine    <= :fine
            AND
                turni.inizio  >= :inizio
            AND
                attivita.id = turni.attivita
            AND
                attivita.luogo IS NOT NULL
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
    
    public function puoPartecipare(Utente $v) {
        return $this->attivita()->puoPartecipare($v);
    }
    
    public function puoRichiederePartecipazione(Utente $v) {
        return (( time() <= $this->inizio ) && $this->attivita()->puoPartecipare($v));
    }

    public function scoperto() {
        return (bool) ( count($this->partecipazioni()) < $this->minimo && $this->inizio()->getTimestamp() > time() );
    }
    
    public function pieno() {
        return (bool) ( count($this->partecipazioni()) >= $this->massimo );
    }
}