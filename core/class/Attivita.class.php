<?php

/*
 * ©2012 Croce Rossa Italiana
 */

class Attivita extends Entita {
        
    protected static
        $_t  = 'attivita',
        $_dt = 'dettagliAttivita';

    public function inizio() {
    	return new DT('@'. $this->inizio);
    }

    public function fine() {
    	return new DT('@'. $this->fine);
    }

    public function comitato() {
    	if ( $this->comitato ) {
    		return new Comitato($this->comitato);
    	} else { 
    		return null;
    	}
    }

    public function responsabile() {
    	return new Volontario($this->responsabile);
    }
}