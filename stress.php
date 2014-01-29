<?php

/*
 * ©2014 Croce Rossa Italiana
 */

require 'core.inc.php';

if ( PHP_SAPI !== 'cli' )
	die('Non puoi invocare lo stress test via webserver.');

if ( $argc < 3 )
	die("Uso: php {$argv[0]} esegui <numero-thread>\n");

if ( !$cache )
	die("ERRORE: Lo stress test richiede il server di cache.\n");

function avviaWorker($id, $vocabolo) {
	global $argv;
	$str = "php {$argv[0]} worker {$id} \"{$vocabolo}\" >/dev/null 2>&1  &";
	echo '.';
	return exec($str);
}

if ( $argv[1] == 'esegui' ) {
	/* SONO IL GESTORE DELLO STRESS TEST */
	$threads = (int) $argv[2];
	echo "Avvio dello stress test con {$threads} threads\n";

	$cache->set('test_worker_terminati', 0);
	$cache->set('test_totale_tempo',   0.0);

	$stress  = file('./upload/setup/stress.txt');
	$nstress = count($stress);
	echo "- Dizionario caricato con {$nstress} vocaboli\n";

	$start  = microtime(true);
	echo "- Avvio degli workers di inizio: ";
	for ( $i = 0; $i < $threads; $i ++ ) {
		avviaWorker($i, $stress[$i]);
	}
	echo " [OK]\n";

	$fatto = 0;
	echo "- Workers: ";
	while ( $fatto < $nstress ) {
		$nuovi     = $cache->get('test_worker_terminati');
		$daAvviare = $nuovi - $fatto;
		for ( $i = 0; $i < $daAvviare; $i++ ) {
			$n = $fatto+($i+1);
			avviaWorker($n, $stress[$n]);
		}
		$fatto = $nuovi;
		usleep(100);
	}

	$tempo = microtime(true) - $start;
	echo "\n== Sommatoria tempi worker: ";
	echo round($cache->get('test_totale_tempo'), 6);
	echo " secondi";
	echo "\n== RISULTATO MULTITHREAD  : ";
	echo round($tempo, 6);
	echo " secondi\n";




} else {
	/* SONO UN WORKER QUALUNQUE */
	$worker_id = (int) $argv[2];
	$start     = microtime(true);

	/* ESECUZIONE WORKER */
	$termine   = $argv[3];
	$r 				= new Ricerca;
	$r->query     	= $termine;
	$r->perPagina 	= 100000;
	$r->pagina      = 1;
	$r->esegui();

	$tempo      = microtime(true) - $start;
	$cache->incrByFloat('test_totale_tempo', $tempo);
	$cache->incrBy('test_worker_terminati',  1);
}