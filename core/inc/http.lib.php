<?php

/*
 * (c)2013 Croce Rossa Italiana
 */

/*
 * Effettua una richiesta HTTP di tipo POST e ne ritorna il corpo della risposta
 * @param string $url L'URL al quale effettuare la richiesta
 * @param array $data Array associativo con i dati della richiesta
 * @return string La risposta
 */
function http_post($url, $data = []) {
	$options = array(
	    'http' => array(
	        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	        'method'  => 'POST',
	        'content' => http_build_query($data),
	    ),
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	return $result;
}
