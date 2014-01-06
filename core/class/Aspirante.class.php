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

    /**
     * Ottiene i comitati nelle vicinanze
     * @return Comitato     array di comitati
    */
    public function comitati() {
        return Comitato::contenutiIn($this);
    }

    /**
     * Ottiene il numero dei comitati nelle vicinanze
     * @return int     numero di comitati
    */
    public function numComitati() {
        return count($this->comitati());
    }

    public function trovaRaggioMinimo() {
        $this->raggio = 0;
        do {
            $this->raggio = ( (float) $this->raggio ) + 0.2;
        } while (
            $this->numComitati() < ASPIRANTI_MINIMO_COMITATI
        );
        return $this->raggio;
    }

    /**
     * Ottiene i corsi base nelle vicinanze
     * @return CorsoBase     array di corsi base
    */
    public function corsiBase() {
        $corsiBase = [];
        foreach($this->comitati() as $c) {
            foreach($c->corsiBase() as $corso) {
                if ($corso->stato == CORSO_S_ATTIVO)
                    $corsiBase[] = $corso;
            }
        }
        return $corsiBase;
    }

    /**
     * Ottiene il numero dei corsi base nelle vicinanze
     * @return int     numero di comitati
    */
    public function numCorsiBase() {
        return count($this->corsiBase());
    }

}
