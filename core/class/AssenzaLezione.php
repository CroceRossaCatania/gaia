<?php

/**
 * ©2014 Croce Rossa Italiana
 */

/**
 * Rappresenta un'assenza ad una lezione.
 */
class AssenzaLezione extends Entita {

	protected static 
		$_t		= 'lezioni_assenze',
		$_dt 	= null;

	use EntitaCache;

	/**
	 * Ritorna la lezione collegata all'assenza
	 * @return Lezione
	 */
	public function lezione() {
		return Lezione::id($this->lezione);
	}

	/**
	 * Ritorna l'utente collegato all'assenza
	 * @return Utente
	 */
	public function utente() {
		return Utente::id($this->utente);
	}

	/** 
	 * Ritorna il corso dell'assenza
	 * @return CorsoBase
	 */
	public function corso() {
		return $this->lezione()->corso();
	}

}