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

    /**
     * Ottiene l'oggetto Aspirante relativo ad un volontario
     * @param Volontario $volontario Il volontario
     * @return Aspirante
    */
    public static function daVolontario($volontario) {
        return static::by('utente', (string) $volontario);
    }

    public function comitati() {
        return Comitato::contenutiIn($this);
    }

    public function numComitati() {
        return count($this->comitati());
    }

    public function trovaRaggioMinimo() {
        $this->raggio = 0;
        do {
            $this->raggio = (int) $this->raggio + 2;
        } while (
            $this->numComitati() < ASPIRANTI_MINIMO_COMITATI
        );
        return $this->raggio;
    }

}
