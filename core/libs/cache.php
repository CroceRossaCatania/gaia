<?php

/*
 * (c)2014 Croce Rossa Italiana
 */


// Creazione dell'hash del database
$conf['db_hash'] = substr( md5($conf['database']['dns']), 2, 8);

/* Connetto alla cache */
if (!class_exists('Redis') )
    die("ERRORE: Estensione PHP per Redis non disponibile.\n");

$cache = new Cache();
$cache->pconnect($conf['redis']['host']);

/**
 * Contiene la versione cache attuale
 */
$_versione_cache = (int) $cache->get(chiave('versione_cache', false));

/** 
 * Ritorna il prefisso della cache attuale
 * con o senza versione, es.:
 * abc5412390asdj4:44:
 * @param bool $conVersione Se inserire versione cache
 * @return string Prefisso cache
 */
function prefissoCache($conVersione = true) {
	global $conf, $_versione_cache;
	$prefisso = $conf['db_hash'] . ':';
	if ( $conVersione ) {
		$prefisso .= $_versione_cache . ':';
	}
	return $prefisso;
}

/**
 * Ritorna una chiave con prefisso di cache
 * @param string Suffisso
 * @param bool Da versionare?
 * @return string
 */
function chiave($suffisso, $conVersione = false) {
	return prefissoCache($conVersione) . $suffisso;
}

/**
 * Incrementa il numero di versione attuale, invalidando la cache
 * @return int Numero di versione attuale
 */
function incrementaVersioneCache() {
	global $cache, $_versione_cache;
	$_versione_cache++;
	$cache->incr(chiave('versione_cache', false), false);
}

/*
 * Svuota la cache Entita su Redis
 * Disclaimer: FUNZIONE LENTA! NON usare in produzione.
 */
function svuotaCacheEntita() {
	global $conf, $cache;
	if (!$cache)
		return false;
	foreach ( $cache->keys(prefissoCache(false) . '*') as $chiave ) {
		$cache->delete($chiave);
	}
	return;
}
