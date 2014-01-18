<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Quota extends Entita {
    
    protected static
        $_t  = 'quote',
        $_dt = null;
    
    public function volontario() {
        return Volontario::id($this->appartenenza()->volontario());
    }
    
    public function appartenenza() {
        return Appartenenza::id($this->appartenenza);
    }
    
    public function comitato() {
        return $this->appartenenza()->comitato();
    }
    
    public function conferma() {
        return Volontario::id($this->pConferma);
    }
    
    /**
     * Genera il codice numerico progressivo della quota sulla base dell'anno attuale
     *
     * @return int|bool(false) $progressivo     Il codice progressivo, false altrimenti 
     */
    public function assegnaProgressivo() {
        if ($this->progressivo) {
            return false;
        }
        $anno = $this->anno;
        $progressivo = $this->generaProgressivo('progressivo', [["anno", $anno]]);
        $this->progressivo = $progressivo;
        return $progressivo;
    }

    /**
     * Ritorna il codice numerico progressivo della quota
     *
     * @return Codice progressivo della quota combinato con l'anno
     */
    public function progressivo() {
        if($this->progressivo) {
            return $this->anno.'/'.$this->progressivo;
        }
        return null;
    }

    public function benemerita() {
        return (bool) $this->benemerito == BENEMERITO_SI;
    }

    public function data() {
        return DT::daTimestamp($this->timestamp);
    }

}
