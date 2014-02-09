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
	if ( $livello > ERRORIAMICHEVOLI_MINIMO )
		return true;

	try {
		$e = new MErrore;
	} catch ( Exception $e ) {
		// Non riuscito, fallback alla modalita' classica...
		gestione_errori_fallback($livello, $messaggio, $file, $linea, $contesto);
		return true;
	}

	// Genera ID richiesta
	if (!$_id_richiesta)
		$_id_richiesta = md5(microtime() . rand(500, 999));
	$codice = sha1(microtime() . rand(10000, 99999));

	$e->codice 		= $codice;
	$e->richiesta 	= $_id_richiesta;
	$e->livello		= $livello;
	$e->messaggio 	= $messaggio;
	$e->file 		= $file;
	$e->linea 		= (int) $linea;
	$e->ambiente 	= [
		'server'		=>	$_SERVER,
		'get'			=>	$_GET,
		'post'			=>	$_POST
	];
	$e->sessione 	= $sessione->id;
	$e->utente 		= $me->id;

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