<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

/**
 * Questa libreria contiene delle funzioni utilizzate per generare
 * il changelog pubblico, creato a partire dall'elenco delle pull
 * request chiuse e commit ottenuti dal repo su GitHub
 */

define('GITHUB_REPO', 				'CroceRossaCatania/gaia');		// Repo GitHub
define('PULL_REQUEST_FILE',			'pulls.json');	// Cache file
define('PULL_REQUEST_FILE_CACHE',	3600);							// Durata cache
define('COMMITS_FILE',				'commits.json');	// Cache file
define('COMMITS_FILE_CACHE',		900);							// Durata cache

/**
 * Scarica le pull request da GitHub e restituisce il file JSON come stringa
 * @return string JSON delle pull request
 */
function scaricaPullRequest() {
	$url = 'https://api.github.com/repos/' . GITHUB_REPO . '/pulls?state=closed';
	$contenuto = file_get_contents($url, false, stream_context_create([
		'http' => [
			'user_agent' => $_SERVER['HTTP_USER_AGENT']
		]
	]));
	file_put_contents(PULL_REQUEST_FILE, $contenuto);
	return $contenuto;
}

/**
 * Scarica i commit da GitHub e restituisce il file JSON come stringa
 * @return string JSON dei commit
 */
function scaricaCommit() {
	$url = 'https://api.github.com/repos/' . GITHUB_REPO . '/commits';
	$contenuto = file_get_contents($url, false, stream_context_create([
		'http' => [
			'user_agent' => $_SERVER['HTTP_USER_AGENT']
		]
	]));
	file_put_contents(COMMITS_FILE, $contenuto);
	return $contenuto;
}

/**
 * Funzione di ordinamento per pull request (vedi usort)
 */
function ordinaPullRequest($a, $b) {
	$a = (int) strtotime($a->merged_at);
	$b = (int) strtotime($b->merged_at);
    if ($a == $b) {
        return 0;
    } 
  	return ($a < $b) ? 1 : -1;
} 

/**
 * Ottiene le pull request (scaricando e mettendo in cache se necessario)
 * come oggetto decodificato JSON, false in caso di fallimento
 * @return JSONObject|false JSON decodificato o false in caso di fallimento
 */
function ottieniPullRequest() {
	$contenuto = diskCache(
		PULL_REQUEST_FILE,
		'scaricaPullRequest',
		PULL_REQUEST_FILE_CACHE
	);
	$contenuto = json_decode($contenuto);
	usort($contenuto, 'ordinaPullRequest');
	return $contenuto;
}

/**
 * Ottiene i commits (scaricando e mettendo in cache se necessario)
 * come oggetto decodificato JSON, false in caso di fallimento
 * @return JSONObject|false JSON decodificato o false in caso di fallimento
 */
function ottieniCommit() {
	$contenuto = diskCache(
		COMMITS_FILE,
		'scaricaCommit',
		COMMITS_FILE_CACHE
	);

	$contenuto = json_decode($contenuto);
	return $contenuto;
}
