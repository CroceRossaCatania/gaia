<?php

/*
 * ©2012 Croce Rossa Italiana
 */

require('./core.inc.php');

// Attiva la compressione GZIP
ob_start('ob_gzhandler');

// Imposta la risposta in JSON
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

// Ottiene il corpo della richiesta
$corpo = file_get_contents('php://input');

// JSON-decode del corpo della richiesta
$corpo = json_decode($corpo);

// Controlla che il corpo sia ben formato
if ( !$corpo ) {
	$corpo = ['raw' => $corpo];
}

// Ottiene il SID, se presente
if ( empty($corpo->sid) ) {
	$sid = null;
} else {
	$sid = (string) $corpo->sid;
}

// Ottiene API KEY, se presente
if ( empty($corpo->key) ) {
	$key = false;
} else {
	$key = (string) $corpo->key;
}

// Ottiene il metodo, se presente
if ( empty($corpo->metodo) ) {
	$metodo = null;
} else {
	$metodo = (string) $corpo->metodo;
}

// Dai un nome alla transazione
nomeTransazione($metodo, 'api');

// Crea la sessione API
$api = new APIServer($key, $sid);

// Carica i parametri
$api->par = (array) $corpo;

// Esegui il metodo richiesto
echo $api->esegui($metodo);
