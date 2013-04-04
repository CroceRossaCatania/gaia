<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Comitato extends Entita {
        
    protected static
        $_t  = 'comitati',
        $_dt = null;

    public function colore() { 
    	$c = $this->colore;
    	if (!$c) {
            $this->generaColore();
            return $this->colore();
    	}
    	return $c;
    }

    private function generaColore() { 
    	$r = 100 + rand(0, 155);
    	$g = 100 + rand(0, 155);
    	$b = 100 + rand(0, 155);
    	$r = dechex($r);
    	$g = dechex($g);
    	$b = dechex($b);
    	$this->colore = $r . $g . $b;
    }

    public function calendarioAttivitaPrivate() {
        return Attivita::filtra([
            ['comitato',  $this->id]
        ]);
    }
    
    public function haMembro ( Persona $tizio, $stato = MEMBRO_VOLONTARIO ) {
        $membri = [];
        foreach ( $this->membriAttuali($stato) as $m ) {
            $membri[] = $m->id;
        }
        if ( in_array($tizio->id, $membri) ) {
            return true;
        } else {
            return false;
        }
    }
    
    public function membriAttuali($stato = MEMBRO_VOLONTARIO) {
        $q = $this->db->prepare("
            SELECT
                volontario
            FROM
                appartenenza
            WHERE
                ( fine >= :ora OR fine IS NULL OR fine = 0) 
            AND
                comitato = :comitato
            AND
                stato    >= :stato
            ORDER BY
                inizio ASC");
        $q->bindValue(':ora', time());
        $q->bindParam(':comitato', $this->id);
        $q->bindParam(':stato',    $stato);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Volontario($k[0]);
        }
        return $r;
    }
    
    public function numMembriAttuali($stato = MEMBRO_VOLONTARIO) {
        $q = $this->db->prepare("
            SELECT
                COUNT(volontario)
            FROM
                appartenenza
            WHERE
                ( fine >= :ora OR fine IS NULL OR fine = 0) 
            AND
                comitato = :comitato
            AND
                stato    >= :stato
            ORDER BY
                inizio ASC");
        $q->bindValue(':ora', time());
        $q->bindParam(':comitato', $this->id);
        $q->bindParam(':stato',    $stato);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_NUM);
        return (int) $r[0];
    }

    public function appartenenzePendenti() {
        $q = $this->db->prepare("
            SELECT
                id
            FROM
                appartenenza
            WHERE
                ( fine >= :ora OR fine IS NULL OR fine = 0) 
            AND
                comitato = :comitato
            AND
                stato    = :stato
            ORDER BY
                inizio ASC");
        $q->bindValue(':ora', time());
        $q->bindParam(':comitato', $this->id);
        $q->bindValue(':stato',    MEMBRO_PENDENTE);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Appartenenza($k[0]);
        }
        return $r;
    }
    
    public function titoliPendenti() {
        $q = $this->db->prepare("
            SELECT 
                titoliPersonali.id
            FROM
                titoliPersonali, appartenenza
            WHERE
                titoliPersonali.volontario = appartenenza.volontario
            AND
                titoliPersonali.pConferma IS NULL
            AND
                appartenenza.comitato = :comitato
            AND
                (appartenenza.fine >= :ora
                 OR appartenenza.fine is NULL
                 OR appartenenza.fine = 0)");
        $q->bindValue(':ora', time());
        $q->bindParam(':comitato', $this->id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new TitoloPersonale($k[0]);
        }
        return $r;
    }
    
    public function presidenti() {
        return $this->membriAttuali(MEMBRO_PRESIDENTE);
    }
    
    public function unPresidente() {
        $p = $this->presidenti();
        if ( !$p ) { return false; }
        shuffle($p);
        return $p[0];
    }
    
    public function delegati($app = null) {
        if ( $app ) {
            $app = (int) $app;
            return Delegato::filtra([
                ['comitato',        $this->id],
                ['applicazione',    $app]
            ]);
        } else {
            return Delegato::filtra([
                ['comitato',    $this->id]
            ]);
        }
    }
    
    public function trasferimenti($stato = null) {
        $stato = (int) $stato;
        $q = "
            SELECT
                trasferimenti.id
            FROM
                trasferimenti, appartenenza
            WHERE
                trasferimenti.appartenenza = appartenenza.id
            AND
                appartenenza.comitato = :id";
        if ( $stato ) {
            $q .= " AND trasferimenti.stato = $stato";
        }
        $q .= " ORDER BY trasferimenti.timestamp DESC";
        $q = $this->db->prepare($q);
        $q->bindParam(':id', $this->id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Trasferimento($k[0]);
        }
        return $r;
    }
    
    public function riserve($stato = null) {
        $stato = (int) $stato;
        $q = "
            SELECT
                riserve.id
            FROM
                riserve, appartenenza
            WHERE
                riserve.appartenenza = appartenenza.id
            AND
                appartenenza.comitato = :id";
        if ( $stato ) {
            $q .= " AND riserve.stato = $stato";
        }
        $q .= " ORDER BY riserve.timestamp DESC";
        $q = $this->db->prepare($q);
        $q->bindParam(':id', $this->id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Riserva($k[0]);
        }
        return $r;
    }
}