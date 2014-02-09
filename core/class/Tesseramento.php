<?php

/*
 * ©2014 Croce Rossa Italiana
 * 
 */

class Tesseramento extends Entita {
    
    protected static
        $_t     = 'tesseramenti',
        $_dt    = null;

    public function inizio() {
        return DT::daTimestamp($this->inizio);
    }

    public function fine() {
        return DT::daTimestamp($this->fine);
    }

    public function aperto() {
        if($this->stato == TESSERAMENTO_APERTO) {
            return true;
        }
        return false;
    }

    /**
     * Se il tesseramento è aperto e la data attuale è superiore a quella di inizio
     * posso iniziare a raccogliere gli euri
     * @return bool True se accetta, false altrimenti
     */
    public function accettaPagamenti() {
        if($this->aperto() && $this->inizio() < DT::daTimestamp(time())) {
            return true;
        }
        return false;
    }

    /**
     * Se il tesseramento è aperto e la data attuale è superiore a quella di fine
     * posso iniziare a scacciare i non paganti
     * @return bool True se accetta, false altrimenti
     */
    public function siPuoDimettereTutti() {
        if($this->aperto() && $this->fine() < DT::daTimestamp(time())) {
            return true;
        }
        return false;
    }

    /**
     * Restituisce le quote di un particolare tesseramento
     * @return Quote    elenco delle quote di un particolare anno
     */
    public function quote() {
        return Quota::filtra([
            ['anno', $this->anno]
            ]);
    }

    /**
     * Verifica se il tesseramento ha quote pagate sopra
     * @return bool True se il tesseramento ha quote, false altrimenti
     */
    public function haQuote() {
        return (bool) $this->quote();
    }

    /**
     * Restituisce un tesseramento aperto, se esiste
     * @return Tesseramento Tesseramento attivo se esiste null altrimenti
     */
    public static function attivo() {
        foreach(Tesseramento::elenco() as $t) {
            if($t->aperto()) {
                return $t;
            }
        }
        return null;
    }
    
}
