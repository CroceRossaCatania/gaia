<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Comitato extends GeoEntita {
        
    protected static
        $_t  = 'comitati',
        $_dt = 'datiComitati';

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
    
    public function membriDimessi($stato = MEMBRO_DIMESSO) {
        $q = $this->db->prepare("
            SELECT
                volontario
            FROM
                appartenenza
            WHERE
                comitato = :comitato
            AND
                stato    >= :stato
            ORDER BY
                inizio ASC");
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
        return $this->delegati(APP_PRESIDENTE);
    }
    
    public function volontariPresidenti() {
        $del = $this->delegati(APP_PRESIDENTE);
        foreach ( $del as &$d ) {
            $d = $d->volontario();
        }
        return $del;
    }
    
    public function unPresidente() {
        $p = $this->presidenti();
        if ( !$p ) { return false; }
        shuffle($p);
        return $p[0]->volontario();
    }
    
    public function delegati($app = null) {
        if ( $app ) {
            $app = (int) $app;
            $k = Delegato::filtra([
                ['comitato',        $this->id],
                ['applicazione',    $app]
            ]);
        } else {
            $k = Delegato::filtra([
                ['comitato',    $this->id]
            ]);
        }
        $r = [];
        foreach ( $k as $u ) {
            if ( $u->attuale() ) {
                $r[] = $u;
            }
        }
        return $r;
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
    
    public function locale() {
        return new Locale($this->locale);
    }
    
    public function provinciale() {
        return $this->locale()->provinciale();
    }
    
    public function regionale() {
        return $this->provinciale()->regionale();
    }
    
    public function nazionale() {
        return $this->regionale()->nazionale();
    }
    
    public function nomeCompleto() {
        return $this->locale()->nome . ': ' . $this->nome;
    }
    
    public function aree( $obiettivo = null ) {
        if ( $obiettivo ) {
            $obiettivo = (int) $obiettivo;
            return Area::filtra([
                ['comitato',    $this->id],
                ['obiettivo',   $obiettivo]
            ], 'obiettivo ASC'); 
        } else {
            return Area::filtra([
                ['comitato',    $this->id]
            ], 'obiettivo ASC');
        }
    }
    
    public function gruppi() {
        return Gruppo::filtra([
            ['comitato',    $this->id]
        ], 'nome ASC');
    }
    
    public function obiettivi_delegati($ob = OBIETTIVO_1) {
        $r = [];
        foreach ( $this->delegati(APP_OBIETTIVO) as $d ) {
            if ( $d->dominio == $ob ) {
                $r[] = $d;
            }
        }
        return $r;
    }
    
    public function obiettivi($ob = OBIETTIVO_1) {
        $r = [];
        foreach ( $this->obiettivi_delegati($ob) as $d ) {
            $r[] = $d->volontario();
        }
        return $r;
    }
    
    public function toJSON() {
        return [
            'nome'          =>  $this->nome,
            'indirizzo'     =>  $this->formattato,
            'coordinate'    =>  $this->coordinate(),
            'telefono'      =>  $this->telefono,
            'email'         =>  $this->email,
            'volontari'     =>  count($this->membriAttuali())
        ];
    }
    
    public function reperibili() {
        $q = "
            SELECT
                reperibilita.id
            FROM
                reperibilita
            WHERE
                reperibilita.comitato = :id";
        $q .= " ORDER BY reperibilita.id DESC";
        $q = $this->db->prepare($q);
        $q->bindParam(':id', $this->id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Reperibilita($k[0]);
        }
        return $r;
    }
    
}