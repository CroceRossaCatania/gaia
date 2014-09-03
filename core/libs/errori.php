<?php

/*
 * ©2014 Croce Rossa Italiana
 */

/** 
 * CONFIGURAZIONE ERRORI AMICHEVOLI
 */
// Ignora errori che ricadono sotto...
define('ERRORIAMICHEVOLI_MINIMO', E_PARSE); 


/**
 * MESSAGGI DI ERRORE 
 */
$conf['errori'] = [
    1000    =>  'Errore non documentato - fare riferimento al supporto tecnico',
    1001    =>  'Errore nello stabilire una connessione al database',
    1002    =>  'Errore nella gestione della cache delle entita',
    1003    =>  'Entità non presente (tabella:id) => ',
    1004    =>	'Metodo API non trovato, fare riferimento alla documentazione',
    1009    =>  'Impossibile debuggare, non autorizzato',
    1010    =>  'Autenticazione necessaria',
    1011    =>  'Almeno un parametro richiesto non e\' stato specificato',
    1012    =>  'Template della mail non presente',
    1013	=>	'Oggetto di tipo non autorizzato',
	1014	=>	'API KEY non valida, disattiva, oppure limite richieste giornaliero superato',
    1015    =>  'Nessuna delegazione selezionata o delegazione non valida',
    1016    =>  'Accesso negato: Nessun permesso di accesso al ramo specificato',
    1017    =>  'Errore di connessione al sistema di distribuzione email desiderato',
    1018    =>  'Email impossibile da inviare: nessun destinatario con indirizzo email',
    1019    =>  'Devi essere identificato per apporre Like di qualsiasi tipo',
    1020    =>  'Puoi apporre solo Like di tipo PIACE e NON_PIACE',
];


registra_gestione_errori();

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
	global $_id_richiesta, $me, $sessione, $conf;

	// Carica MErrore anche se l'autoloading e' stato disabilitato
	_gaia_autoloader('MErrore');

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
	$e->timestamp	= (int) time();
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

	// Salta redirect nel caso di modalita' debug
	if ( $conf['debug'] )
		return false;

	// Eventualmente redirige alla pagina errore fatale
	if ( $livello == E_ERROR || $livello == E_USER_ERROR )
		redirect("errore.fatale&errore={$e}");

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


function gestore_errori_fatali() {
	$error = error_get_last();
	if ( !$error || $error['type'] !== E_ERROR )
		return true;
	$errno   = E_ERROR;
	$errfile = $error["file"];
	$errline = $error["line"];
	$errstr  = $error["message"];
	gestore_errori($errno, $errstr, $errfile, $errline);
	return true;
}

function registra_gestione_errori() {
	// Cattura errori fatali allo shutdown
	register_shutdown_function('gestore_errori_fatali');
	// Tutti gli altri errori...
	set_error_handler('gestore_errori');
}

function errore_ottieni_testo( $num ) {
	switch ( $num ) {
		case E_ERROR:
			return 'Fatal error';
		case E_WARNING:
			return 'Warning';
		case E_NOTICE:
			return 'Notice';
		case E_STRICT:
			return 'Strict';
		default:
			return 'Other';
			break;
	}
}

function errore_ottieni_classe( $num ) {
	switch ( $num ) {
		case E_ERROR:
			return 'error';
		case E_WARNING:
			return 'warning';
		case E_NOTICE:
			return 'notice';
		case E_STRICT:
			return 'strict';
		default:
			return ' ';
			break;
	}
}


function errore_ottieni_icona( $num ) {
	switch ( $num ) {
		case E_ERROR:
			return 'icon-exclamation-sign';
		case E_WARNING:
			return 'icon-warning-sign';
		case E_NOTICE:
			return 'icon-info-sign';
		case E_STRICT:
			return 'icon-ok-sign';
		default:
			return ' ';
			break;
	}
}