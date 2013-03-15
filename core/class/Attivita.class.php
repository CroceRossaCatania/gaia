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
    		return null;
    	}
    }

    public function referente() {
    	return new Volontario($this->referente);
    }
    
    public static function ricercaPubbliche($x, $y, $raggio) {
        return Attivita::filtraRaggio($x, $y, $raggio, [
            ['pubblica',    ATTIVITA_PUBBLICA]
        ]);
    }
    
    public function turni() {
        $q = $this->db->prepare("
            SELECT      id
            FROM        turni
            WHERE       attivita = :id
            ORDER BY    inizio ASC,
                        nome   ASC");
        $q->bindParam(':id',    $this->id);
        $q->execute();
        $r = [];
        while ( $k = $q->fetch(PDO::FETCH_NUM) ) {
            $r[] = new Turno($k[0]);
        }
        return $r;
    }
    
    public function cancella() {
        foreach ( $this->turni() as $t ) {
            $t->cancella();
        }
        parent::cancella();
    }
    
}