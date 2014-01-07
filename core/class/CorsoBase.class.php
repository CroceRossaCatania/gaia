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
    public function assegnaProgressivo() {
        if ($this->progressivo) {
            return false;
        }
        $anno = $this->inizio()->format('Y');
        $progressivo = $this->generaProgressivo('progressivo', [["anno", $anno]]);
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
        return "Corso Base per Volontari del ".$this->organizzatore()->nomeCompleto();
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

    public function modificabileDa(Utente $u) {
        return (bool) (
                $u->id == $this->direttore
            ||  in_array($this, $u->corsiBaseDiGestione())
        );
    }

    public function cancellabileDa(Utente $u) {
        return (bool) in_array($this, $u->corsiBaseDiGestione());
    }

    public function direttore() {
        if ($this->direttore) {
            return Volontario::id($this->direttore);    
        }
        return null;
    }

    public function progressivo() {
        if($this->progressivo) {
            return 'BASE-'.$this->anno.'/'.$this->progressivo;
        }
        return null;
    }

    /**
     * Elenco delle lezioni di un corso base
     * @return Lezioni array di lezioni
     */
    public function lezioni() {
        return [];
    }

    /**
     * True se il corso è attivo e non iniziato
     * @return bool     stato del cors
     */
    public function accettaIscrizioni() {
        return (bool) ($this->futuro()
            and $this->stato == CORSO_S_ATTIVO);
    }

    public function iscritto(Utente $u) {
        $p = PartecipazioneBase::filtra([
            ['volontario', $u->id],
            ['corsoBase', $this->id]
            ]);
        foreach($p as $_p) {
            if($_p->attiva()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Elenco delle partecipazioni degli iscritti
     * @return PartecipazioneBase elenco delle partecipazioni degli iscritti 
     */
    public function partecipazioni() {
        $p = PartecipazioneBase::filtra([
            ['corsoBase', $this->id]
            ]);
        $part = [];
        foreach($p as $_p) {
            if($_p->attiva()) {
                $part[] = $_p;
            }
        }
        return $part;
    }

    /**
     * Elenco degli iscritti ad un corso base
     * @return Utente elenco degli iscritti 
     */
    public function iscritti() {
        $p = PartecipazioneBase::filtra([
            ['corsoBase', $this->id]
            ]);
        $iscritti = [];
        foreach($p as $_p) {
            if($_p->attiva()) {
                $iscritti[] = $_p->utente();
            }
        }
        return $iscritti;
    }

    /**
     * Numero degli iscritti ad un corso base
     * @return int numero degli iscritti 
     */
    public function numIscritti() {
        return count($this->iscritti());
    }

}