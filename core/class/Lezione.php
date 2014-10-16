<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

/**
 * Rappresenta una lezione di un corso base.
 */
class Lezione extends Entita {

	protected static 
		$_t		= 'lezioni',
		$_dt 	= null;

	//use EntitaCache;

	/**
	 * Ritorna il Corso collegato alla lezione
	 * @return CorsoBase
	 */
	public function corso() {
		return CorsoBase::id($this->corso);
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
	 */
	public function assente(Utente $u) {
		return in_array($u, $this->assenti());
	}

	public function presente(Utente $u) {
		return !$this->assente($u);
	}

	/**
	 * Ritorna l'elenco di Utenti assenti ad una data Lezione
	 * @return array(Utente)
	 */
	public function assenti() {
		$r = [];
		foreach ( $this->assenze() as $a ) {
			$r[] = $a->utente();
		}
		return $r;
	}

    public function inizio() {
        return DT::daTimestamp($this->inizio);
    }

    public function fine() {
        return DT::daTimestamp($this->fine);
    }

    public function passata() {
    	$ora = new DT;
    	return $ora >= $this->fine();
    }

	/**
	 * Ritorna l'elenco di presenti alla lezione.
	 * Questa viene generata sottraendo gli assenti alla lezione
	 * dall'elenco dei partecipenti confermati al corso base.
	 * @return array(Utente)
	 */
	public function presenti() {
		$iscritti = $this->corso()->iscritti();
		return array_diff($iscritti, $this->assenti());
	}

	public function cancella() {
		foreach ( $this->assenze() as $a ) {
			$a->cancella();
		}
		parent::cancella();
	}

}