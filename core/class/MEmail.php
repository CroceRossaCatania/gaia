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

EMAIL
id 					varchar(127) PRIMARY KEY,
invio_iniziato		bigint		 INDEX,
invio_terminato		bigint		 INDEX,
mittente_id			int 		 INDEX,
oggetto 			varchar(255)	  ,
corpo 				text 			  ,
timestamp 			bigint 		 INDEX,

EMAIL_ALLEGATI
email 				varchar(127) PRIMARY KEY,
allegato_id 		varchar(64) 		 ,
allegato_nome 		varchar(255)


EMAIL_DESTINATARI
email   	varchar(127) 	INDEX,
dest 		int 			INDEX,
inviato 	bigint 			INDEX,
ok 			boolean				 ,
errore  	varchar(255)		 ,

*/

/**
 * Rappresenta una email salvata in storico (db mysql)
 */
class MEmail extends Entita {

    use EntitaNoCache;

    protected static
        $_t         = 'email',
        $_dt        = null;


	protected function generaId() {
		return sha1(
			microtime() . rand(10000, 99999)
		);
	}

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
		global $db;

		$inviato	=	(int) time();

		if ( $ok ) {
			$ok		=	true;
			$errore	=	"";
		} else {
			$ok		=	false;
			$errore	=	$messaggio;
		}

		$q = $db->prepare(
			"UPDATE email_destinatari SET 
				inviato = :inviato, ok = :ok, errore = :errore
			  WHERE 
			  	email = :email AND dest = :dest");
		$q->bindParam(':inviato', 	$inviato,	PDO::PARAM_INT);
		$q->bindParam(':ok', 		$ok,		PDO::PARAM_INT);
		$q->bindParam(':errore',	$errore);
		$q->bindParam(':email',		$this->id);
		$q->bindParam(':dest',		$destinatario_id, PDO::PARAM_INT);
		return $q->execute();
	}

	/**
	 * Imposta inizio invio email 
	 */
	protected function _inizia_invio() {
		if ( !$this->invio_iniziato ) {
			$this->invio_iniziato  = (int) time();
			$this->invio_terminato = false;
		}
	}

	/**
	 * Imposta email terminata di inviare
	 */
	protected function _termina_invio() {
		if ( !$this->invio_terminato ) {
			$this->invio_iniziato 	=	$this->invio_iniziato;
			$this->invio_terminato	=	(int) time();
		}
	}

	public function destinatari() {
		global $db;
		$q = "SELECT *, email as id FROM email_destinatari WHERE email = :id";
		$q = $db->prepare($q);
		$q->bindParam(':id', $this->id);
		$q->execute();
		if ( !$q ) {
			return false;
		}
		return $q->fetchAll(PDO::FETCH_ASSOC);
	}

	public function allegati() {
		global $db;
		$q = "SELECT * FROM email_allegati WHERE email = :id";
		$q = $db->prepare($q);
		$q->bindParam(':id', $this->id);
		$q->execute();
		if ( !$q ) {
			return [];
		}
		return $q->fetchAll(PDO::FETCH_ASSOC);
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
		if ( $this->mittente_id ) {
			$u = Utente::id($this->mittente_id);
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
		foreach ( $this->allegati() as $allegato ) {
			try {
				// Cerca file dell'allegato...
				$a = File::id($allegato['allegato_id']);
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

		$destinatari = $this->destinatari();
		if ( !(bool)$destinatari ) { 
			$y->AddAddress(
				'supporto@gaia.cri.it',
				'Supporto Gaia'
			);
			$riuscito = (bool) $y->send();

		} else {
			
			$riuscito = true;

			// Per ogni destinatario...
			foreach ( $destinatari as $dest ) {

				// Salta se gia' inviato!
				if ( $dest['inviato'] && $dest['ok'] )
					continue;

				$utente = Utente::id($dest['dest']);
				// Destinatario non esistente
				if ( !$utente ) {
					$this->_errore_invio($dest['dest']);
					continue;
				}

				// Invia l'email in questione
				$y->AddAddress(
					$utente->email,
					$utente->nomeCompleto()
				);
				$stato = $y->send();
				$this->_stato_invio(
					$dest['dest'],
					$stato,
					$y->ErrorInfo
				);

				$riuscito = $riuscito && $stato;

				$y->ClearAllRecipients();

				if ( is_callable($callback) )
					call_user_func($callback);

			}

		}

		if ( $riuscito )
			$this->_termina_invio();

		return $riuscito;

	}

	/**
	 * Ritorna il messaggio in formato JSON
	 * Se $filtraDestinatario e' impostato, rimuove tutti i 
	 * destinatari meno che quello passato come argomento
	 * @param false|id 			Filtra destinatario?
	 * @return array associativo nestato
	 */
	public function toJSON($filtraDestinatario = false) {
	
		$destinatari = $this->destinatari();
		if ( $destinatari ) {
			foreach  ( $destinatari as $i => &$_d ) {
				$_d['id'] = $_d['dest'];
				if ( $filtraDestinatario && $_d['id'] != $filtraDestinatario ) {
					unset($destinatari[$i]);
				}
			}
			$destinatari = array_values($destinatari);
		}

		$allegati = $this->allegati();
		foreach ( $allegati as $i => &$k ) {
			$k['id'] 	= $k['allegato_id'];
			$k['nome'] 	= $k['allegato_nome'];
		}

		$mittente = $this->mittente_id ?
			[ 'id' => $this->mittente_id ]
			: false;

		return [
			'_id'		=>	$this->id,
			'id'		=>	$this->id,
			'oggetto'	=>	$this->oggetto ? $this->oggetto : '(Nessun oggetto)',
			'timestamp'	=>	$this->timestamp,
			'invio' 	=> [
				'iniziato'	=>	$this->invio_iniziato,
				'terminato' =>	$this->invio_terminato
			],
			'mittente'		=> $mittente,
			'destinatari' 	=> $destinatari,
			'corpo'		=> $this->corpo,
			'allegati'	=> $this->allegati()
		];
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
	 * Ottiene le email ancora da inviare...
	 * @return array(MEmail) Email ancora da inviare
	 */
	public static function inCoda( $limit = false ) {
		$l = $limit ? " LIMIT 0, " . ((int) $limit) : "";
		return static::filtra([
			['invio_terminato', null, OP_ISNULL]
		], "timestamp DESC {$l}");
	}

}