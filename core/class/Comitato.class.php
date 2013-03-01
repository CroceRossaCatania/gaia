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
    	$r = 55 + rand(0, 200);
    	$g = 55 + rand(0, 200);
    	$b = 55 + rand(0, 200);
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
    
    public function membriAttuali($stato = MEMBRO_PENDENTE) {
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
    
    public function numMembriAttuali($stato = MEMBRO_PENDENTE) {
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

}