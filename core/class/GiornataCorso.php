<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

/**
 * Rappresenta una giornataCorso di un corso.
 */
class GiornataCorso extends Entita {

    protected static 
        $_t	= 'crs_giornataCorso',
        $_dt 	= null;

    use EntitaCache;

    /**
     * Ritorna il Corso collegato alla lezione
     * @return CorsoBase
     */
    public function corso() {
        return Corso::id($this->corso);
    }

    /**
     * Ritorna l'elenco di assenze registrate per una data Lezione
     * @return array(AssenzaLezione)
     */
    public function assenze() {
            return AssenzaLezione::filtra([['lezione', $this->id]]);
    }

    /**
     * Ritorna se un Utente e' assente o meno alla lezione
     * @param Utente $utente
     * @param bool 
     
    public function assente(Utente $u) {
            return contiene($u, $this->assenti());
    }

    public function presente(Utente $u) {
            return !$this->assente($u);
    }
    */
    
    
    /**
     * Ritorna l'elenco di Utenti assenti ad una data Lezione
     * @return array(Utente)
     
    public function assenti() {
        $r = [];
        foreach ( $this->assenze() as $a ) {
                $r[] = $a->utente();
        }
        return $r;
    }
    */
    
    public function data() {
        return DT::daTimestamp($this->data);
    }

    /*
    public function fine() {
        return DT::daTimestamp($this->fine);
    }

    public function passata() {
    	$ora = new DT;
    	return $ora >= $this->fine();
    }
    */
    
    /**
     * Ritorna l'elenco di presenti alla lezione.
     * Questa viene generata sottraendo gli assenti alla lezione
     * dall'elenco dei partecipenti confermati al corso base.
     * @return array(Utente)
     
    public function presenti() {
        $iscritti = $this->corso()->iscritti();
        return array_diff($iscritti, $this->assenti());
    }

    public function cancella() {
        AssenzaLezione::cancellaTutti([['lezione', $this->id]]);
        parent::cancella();
    }
     *
     */
    
}