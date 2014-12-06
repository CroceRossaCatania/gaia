<?php

/*
 * (c)2014 Croce Rossa Italiana
 */

// Base path per la cache su disco
define('DISKCACHE_BASE', 	'./upload/setup/');
define('DISKCACHE_DEFAULT',	900); // Durata cache

/**
 * Wrapper in cache su disco attorno ad una funzione
 * @param string 	$nomeFile 	Il nome del file in cache
 * @param callable  $funzione 	La funzione che ritorna il valore da mettere in cache
 * @param int 		$scadenza	(Opzionale) La durata della cache
 */
function diskCache($nomeFile, $callable, $durata = DISKCACHE_DEFAULT) {
	$file = DISKCACHE_BASE . "cache_{$nomeFile}";
	if ( is_readable($file) && filemtime($file) > time() - $durata ) {
		return file_get_contents($file);
	} else {
		$r = call_user_func($callable);
		file_put_contents($file, $r);
		return $r;
	}
}
