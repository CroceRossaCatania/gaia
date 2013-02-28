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

}