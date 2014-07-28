<?php

/*
 * ©2014 Croce Rossa Italiana
 */

class Collocazione extends Entita {

	protected static
        $_t     = 'collocazioneVeicoli',
        $_dt    =  null;

    /**
     * Ritorna true se attuale
     * @return True or False
     */
    public function attuale() {
        return ( ( $this->fine > time() ) || ( !$this->fine ) );
    }

    /**
     * Ritorna autoparco
     * @return Object Autoparco
     */
    public function autoparco() {
        return Autoparco::id($this->autoparco);
    }

    /**
     * Ritorna la data di inizio collocazione
     * @return DT
     */
    public function inizio() {
    	if ( $this->inizio ){
    		return date('d/m/Y H:i', $this->inizio);
    	}else{
    		return "Indeterminato";
    	}
    }

    /**
     * Ritorna la data di fine collocazione
     * @return DT
     */
    public function fine() {
    	if ( $this->fine ){
    		return date('d/m/Y H:i', $this->fine);
    	}else{
    		return "Indeterminato";
    	}
    }
    
}