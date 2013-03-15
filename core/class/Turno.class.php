<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Turno extends Entita {
    
    protected static
        $_t  = 'turni',
        $_dt = null;

    public function inizio() {
    	return new DT('@'. $this->inizio);
    }

    public function fine() {
    	return new DT('@'. $this->fine);
    }

}