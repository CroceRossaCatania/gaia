<?php

/*
 * ©2014 Croce Rossa Italiana
 */

/**
 * ID univoco della richiesta
 * @var $_id_richiesta Contiene l'ID della richiesta attuale
 */
$_id_richiesta = false;

/**
 * Gestore amichevole degli errori
 * @see http://www.php.net/manual/en/function.set-error-handler.php
 */
function gestore_errori( 
	$livello,
	$messaggio,
	$file     = 'Nessun file specificato',
	$linea    = 0,
	$contesto = []
) {
	global $_id_richiesta, $me, $sessione;

	// Ignora gli errori poco importanti
	if ( $livello < ERRORIAMICHEVOLI_MINIMO )
		return true;

	try {
		// Prova a connettersi al database degli errori
		$dbe = new SQLite3(ERRORIAMICHEVOLI_DATABASE);
	} catch ( Exception $e ) {
		// Non riuscito, fallback alla modalita' classica...
		gestione_errori_fallback($livello, $messaggio, $file, $linea, $contesto);
		return true;
	}

	// Crea la tabella se non esiste
	$dbe->exec("
		CREATE TABLE IF NOT EXISTS 
			errori (
				codice, richiesta, timestamp, livello, messaggio, file, linea, server, get, post, sessione, utente
			)
	");

	// Genera ID richiesta
	if (!$_id_richiesta)
		$_id_richiesta = md5(microtime() . rand(500, 999));
	$codice = sha1(microtime() . rand(10000, 99999));

	$q = $dbe->prepare("
		INSERT INTO errori 
			(codice, richiesta, timestamp, livello, messaggio, file, linea, server, get, post, sessione, utente)
		VALUES
			(:codice, :richiesta, :timestamp, :livello, :messaggio, :file, :linea, :server, :get, :post, :sessione, :utente)");
	$q->bindValue(':codice', 	$codice);
	$q->bindValue(':richiesta',	$_id_richiesta);
	$q->bindValue(':timestamp',	time());
	$q->bindValue(':livello',	$livello);
	$q->bindValue(':messaggio',	$messaggio);
	$q->bindValue(':file',		$file);
	$q->bindValue(':linea',		$linea);
	$q->bindValue(':server',	gestore_errori_dump($_SERVER));
	$q->bindValue(':get',		gestore_errori_dump($_GET));
	$q->bindValue(':post',		gestore_errori_dump($_POST));
	$q->bindValue(':sessione',	$sessione->id);
	$q->bindValue(':me',		$me);
	$r = $q->execute();

	// Fallback se mancata esecuzione
	if ( !$r )
		gestione_errori_fallback($livello, $messaggio, $file, $linea, $contesto);

	// Eventualmente redirige alla pagina errore fatale
	if ( $livello == E_ERROR || $livello == E_USER_ERROR )
		redirect("errore.fatale&errore={$codice}");

	return true;

}

/**
 * Gestore non-amichevole degli errori (fallback mode)
 * @see http://www.php.net/manual/en/function.set-error-handler.php
*/
function gestore_errori_fallback(
	$livello,
	$messaggio,
	$file     = 'Nessun file specificato',
	$linea    = 0,
	$contesto = []
) {

	$corpo = json_encode([
		'livello'	=>	$livello,
		'timestamp'	=>	microtime(true),
		'messaggio'	=>	$messaggio,
		'file'		=>	$file,
		'linea'		=>	$linea,
		'contesto'	=>	$contesto,
		'richiesta'	=>	$_REQUEST,
	]);
	$corpo = base64_encode($corpo);

	$testo = <<<STRINGA
	<hr />
	<h2>Errore fatale</h2>
	<p>C'e' stato un errore durante l'elaborazione della pagina.</p>
	<p>Non e' stato possibile segnalare automaticamente l'errore agli sviluppatori.</p>
	<p><strong>Per favore, scrivi a supporto@gaia.cri.it citando il seguente blocco:</strong></p>
	<code>$corpo</code>
	<hr />
STRINGA;

	header('HTTP/1.1 500 Internal Server Error');
	die($testo);

}

/**
 * Dumper di una variabile per il log degli errori
 * @param mixed $variabile La variabile da dumpare
 * @return string
 */
function gestore_errori_dump($variabile) {
	$variabile = json_encode($variabile, JSON_PRETTY_PRINT);
	return $variabile;
}

register_shutdown_function('gestore_errori_fatali');

function gestore_errori_fatali() {
	$error = error_get_last();
	if ( !$error )
		return true;
	$errno   = $error["type"];
	$errfile = $error["file"];
	$errline = $error["line"];
	$errstr  = $error["message"];
	gestore_errori($errno, $errstr, $errfile, $errline);
	return true;
}

function gestore_errori_registra() {
	
}