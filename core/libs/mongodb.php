<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

// CONNESSIONE A MONGODB
try {
	$mdb = new MongoClient(
		$conf['mongodb']['connection'],
		$conf['mongodb']['options']
	);
	$mdb = $mdb->selectDB($conf['mongodb']['database']);
} catch ( Exception $e ) {
	die("Errore di connessione al database MongoDB.
		 Messaggio: {$e->getMessage()}\n");
}
