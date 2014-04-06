<?php

/*
 * (c)2014 Croce Rossa Italiana
 */

/* Connetto alla cache */
if (!class_exists('Redis') )
    die("ERRORE: Estensione PHP per Redis non disponibile.\n");

$cache = new Redis();
$cache->pconnect($conf['redis']['host']);

/*
 * Svuota la cache Entita su Redis
 * Disclaimer: FUNZIONE LENTA! NON usare in produzione.
 */
function svuotaCacheEntita() {
	global $conf, $cache;
	if (!$cache)
		return false;
	foreach ( $cache->keys($conf['db_hash'] . '*') as $chiave ) {
		$cache->delete($chiave);
	}
	return;
}
