<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/**
 * Rappresenta un Corso Base.
 */
class CorsoBase extends GeoEntita {

    protected static
        $_t  = 'corsibase',
        $_dt = null;

    /**
     * Genera il codice numerico progressivo del corso sulla base dell'anno attuale
     *
     * @return int|bool(false) $progressivo     Il codice progressivo, false altrimenti 
     */
    public function assegnaProgessivo() {
        if ($this->progressivo) {
            return false;
        }
        $anno = $this->inizio('Y');
        $progressivo = $this->generaProgressivo('progressivo', ['anno'=>$inizio]);
        $this->progressivo = $progressivo;
        return $progressivo;
    }

    /**
     * Ritorna l'organizzatore del corso base
     * @return GeoPolitica
     */
    public function organizzatore() {
    	return GeoPolitica::daOid($this->organizzatore);
    }

    /**
     * Ritorna la data di inizio del corso base
     * @return DT
     */
    public function inizio() {
    	return DT::daTimestamp($this->inizio);
    }

    /**
     * Controlla se il corso e' futuro (non iniziato)
     * @return bool
     */
    public function futuro() {
    	return $this->inizio() > new DT;
    }

    /**
     * Controlla se il corso e' iniziato
     * @return bool
     */
    public function iniziato() {
    	return !$this->futuro();
    }

    /**
     * Ottiene l'elenco di aspiranti nella zona
     * (non deve essere visibile da nessuno!)
     * @return array(Aspirante)
     */
    public function potenzialiAspiranti() {
    	return Aspirante::chePassanoPer($this);
    }

    /**
     * Localizza nella sede del comitato organizzatore
     */
    public function localizzaInSede() {
    	$sede = $this->organizzatore()->coordinate();
    	$this->localizzaCoordinate($sede[0], $sede[1]);
    }
    
    /**
     * Restituisce il nome del corso
     * @return string     il nome del corso
     */
    public function nome() {
        return "Corso Base per Volontari di ".$this->organizzatore()->nomeCompleto();
    }

    /**
     * Informa se un corso è non concluso
     * @return bool     false se concluso, true altrimenti
     */
    public function attuale() {
        if($this->stato > CORSO_S_CONCLUSO)
            return true;
        return false;
    }

}