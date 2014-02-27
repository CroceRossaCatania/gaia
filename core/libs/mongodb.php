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


/**
 * Dato un iteratore mongo, ritorna un array contenente un array associativo
 * per risultato, con aggiunto un campo 'id'
 * @param $iteratore MongoCursor
 * @return array
 */
function mongo2array($iteratore) {
	$r = [];
	foreach ( $iteratore as $i ) {
		$id = ['id' => (string) $i['_id']];
		$r[] = array_merge($i,
			$id
		);
	}
	return $r;

}