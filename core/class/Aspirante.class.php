<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/**
 * Rappresenta un aspirante volontario, con la sua posizione
 * e raggio di interessamento al prossimo corso base
 */
class Aspirante extends GeoCirco {
        
    protected static
        $_t  = 'aspiranti',
        $_dt = 'aspiranti_dettagli';

    /**
     * Ottiene l'utente collegato all'oggetto aspirante
     * @return Utente
     */
    public function utente() {
    	return Utente::id($this->utente);
    }

    /**
	 * Ottiene la data di inserimento della richiesta
	 * @return DT
	 */   
    public function data() {
    	return DT::daTimestamp($this->data);
    }



}
