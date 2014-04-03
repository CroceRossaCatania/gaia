<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

/*

Formato di un record
==============================
{
	_id:		<stringa>
	oggetto: 	<stringa>,
	timestamp:	<timestamp>,
	invio: {
		iniziato:	<false|timestamp>,
		terminato:	<false|timestamp>
	},
	mittente: 	false|{			// false=Gaia
		id: 	<intero>
	},
	destinatari: false|[		// true=supporto
		{
			id:  		<intero>,
			inviato:	<false|timestamp>,
			ok:			<null|bool>,
			errore:		<null|book>
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
	protected function _stato_invio($destinatario_id, $ok = false, $messaggio = null) {
		if ( $ok ) {
			$n = [
				'id'		=>	$destinatario_id,
				'inviato'	=>	(int) time(),
				'ok'		=>	true
			];
		} else {
			$n = [
				'id'		=>	$destinatario_id,
				'inviato'	=>	(int) time(),
				'ok'		=>	false,
				'errore'	=>	$messaggio
			];
		}
		$this->collection->update(
			[
				'_id' 				=> $this->_objectId,
				'destinatari.id'	=> $destinatario_id
			],
			[
				'$set' => [
					'destinatari.$' => $n
				]
			]
		);
	}

	/**
	 * Imposta inizio invio email 
	 */
	protected function _inizia_invio() {
		if ( !$this->invio['iniziato'] ) {
			$this->invio = [
				'iniziato' 	=>	(int)	time(),
				'terminato'	=>	false
			];
		}
	}

	/**
	 * Imposta email terminata di inviare
	 */
	protected function _termina_invio() {
		if ( !$this->invio['terminato'] ) {
			$this->invio = [
				'iniziato' 	=>	$this->invio['iniziato'],
				'terminato'	=>	(int) time()
			];
		}
	}

	/**
	 * Invia l'email usando configurazione attuale
	 * @param callback|null $callback Eventuale callback da chiamare dopo ogni invio
	 */
	public function invia( $callback = null ) {
		global $conf;

		// Ottiene un mailer
		$y = $this->_mailer();

		// Imposta il mittente
		$y->From 		= 'noreply@gaia.cri.it';
		$y->FromName	= 'Croce Rossa Italiana';

		// Configurazione del mittente
		if ( $this->mittente ) {
			$u = Utente::id($this->mittente['id']);
			$y->addReplyTo($u->email(), $u->nomeCompleto());

		} else {
			// Se non specificato, rispondi al Supporto
			$y->addReplyTo('supporto@gaia.cri.it', 'Supporto Gaia');

		}

		// Configurazione oggetto e corpo
		$y->Subject 	= $this->oggetto;
		$y->isHTML(true);
		$y->Body 		= $this->corpo;
		$y->CharSet 	= 'UTF-8';

		// Configurazione degli allegati
		foreach ( $this->allegati as $allegato ) {
			try {
				// Cerca file dell'allegato...
				$a = File::id($allegato['id']);
			} catch ( Errore $e ) {
				// Se allegato mancante, salta...
				continue;
			}
			$y->addAttachment(
				$a->percorso(),
				$a->nome
			);
		}

		// Imposta invio inizio...
		$this->_inizia_invio();

		$riuscito = false;

		// Se non ci sono destinatari...
		if ( !(bool)$this->destinatari ) {
			$y->AddAddress(
				'supporto@gaia.cri.it',
				'Supporto Gaia'
			);
			$riuscito = (bool) $y->send();

		} else {
			
			$riuscito = true;

			// Per ogni destinatario...
			foreach ( $this->destinatari as $dest ) {

				// Salta se gia' inviato!
				if ( $dest['inviato'] && $dest['ok'] )
					continue;

				$utente = Utente::id($dest['id']);
				// Destinatario non esistente
				if ( !$utente ) {
					$this->_errore_invio($dest['id']);
					continue;
				}

				// Invia l'email in questione
				$y->AddAddress(
					$utente->email,
					$utente->nomeCompleto()
				);
				
				$stato = $y->send();

				$this->_stato_invio(
					$dest['id'],
					$stato,
					$y->ErrorInfo
				);

				$riuscito = $riuscito && $stato;

				$y->ClearAllRecipients();

				if ( is_callable($callable) )
					call_user_func($callable);

			}

		}

		if ( $riuscito )
			$this->_termina_invio();

		return $riuscito;

	}

	/**
	 * Crea e restituisce un oggetto PHP Mailer configurato
	 * @return PHPMailer
	 */
	protected function _mailer() {
		global $conf;
		$y = new PHPMailer;

		// Eventuale configurazione SMTP
		if ( $conf['email']['smtp'] ) {
			$y->isSMTP();
			$y->Host 		= $conf['email']['host'];
			$y->SMTPAuth 	= $conf['email']['auth'];
			$y->Username  	= $conf['email']['username'];
			$y->Password  	= $conf['email']['password'];
			$y->SMTPSecure 	= $conf['email']['secure'];
		}

		// Eventuale configurazione SMTP
		if ( $conf['email']['debug'] ) {
			$y->SMTPDebug   = 2;
			$y->Debugoutput = 'html';
		}	

		if ( !$y )
			throw new Errore(1017);

		return $y;
	}

	/**
	 * Ottiene il MongoCursor alle email ancora da inviare...
	 * @return MongoCursor Cursore alle email ancora da inviare
	 */
	public static function inCoda() {
		return static::find([
			'invio.terminato'	=>	false
		])->sort([
			'timestamp' => 1
		]);
	}

}