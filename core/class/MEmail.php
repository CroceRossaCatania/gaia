<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

/*

{
	_id:		<stringa>
	oggetto: 	<stringa>,
	timestamp:	<timestamp>,
	invio: {
		iniziato:	<false|timestamp>,
		terminato:	<false|timestamp>
	},
	mittente: 	null|{
		id: 	<intero>
	},
	destinatari: [
		{
			id:  		<intero>,
			inviato:	<false|timestamp>,
			ok:			<null|bool>
		},
		...
	],
	corpo:		<corpo>,
	allegati:	[
		{ 
			id:			<intero>,
			nome:		<nome>,
		}
	]
}

*/

/**
 * Rappresenta una email salvata in storico (db mongo)
 */
class MEmail extends MEntita {

	/** 
	 * Imposta errore di invio al destinatario con ID
	 * @param $destinatario_id ID del destinatario
	 */
	protected function _errore_invio($destinatario_id) {
		$this->_stato_invio($destinatario_id, false);
	}

	/** 
	 * Imposta stato di invio al destinatario con ID
	 * @param $destinatario_id ID del destinatario
	 */
	protected function _stato_invio($destinatario_id, $ok = false) {

	}

	/**
	 * Invia l'email usando configurazione attuale
	 */
	public function invia() {
		// Per ogni destinatario...
		foreach ( $this->destinatari  as $dest ) {

			// Salta se gia' inviato!
			if ( $dest['inviato'] )
				continue;

			$utente = Utente::id($dest['id']);
			// Destinatario non esistente
			if ( !$utente ) {
				$this->_errore_invio($dest['id']);
				continue;
			}

			// Invia l'email in questione
			$this->_stato_invio($dest['id'], 
				$this->_invia_email($utente->email())
			);
		}
	}

}