<?php

/*
 * ©2014 Croce Rossa Italiana
 */

class APIKey extends Entita {

    protected static
        $_t  = 'api_chiavi',
        $_dt = null;

    public function aggiorna() {
    	$this->oggi = (int) $this->oggi + 1;
    }

    public function limite() {
    	if ( $l = $this->limite ) {
    		return (int) $l;
    	}
    	return false;
    }

    public function attiva() {
    	return (bool) $this->attiva;
    }

    public function usabile() {
    	if ( !$this->attiva() )		// Chiave attiva?
			return false;
		if ( $this->limite() && $this->oggi > $this->limite() )	// Limite superato?
			return false;
		return true;
    }

    public function generaChiave() {
    	$this->chiave = sha1(microtime(true).rand(10000,99999));
    }


}