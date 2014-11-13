<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

//
// ===============================
// | GESTORE DELLA CODA DI INVIO |
// ===============================
//
// Giusto un paio di regole:
//  a) Deve essere avviato DA CRONJOB, con:
//     * * * * * php {...}/mailer.php | tee -a {...}/mailer.log
//  b) Non ritorna nessun output se tutto va bene!
//  c) Non devono esserci piu' istanze in parallelo (controllo interno)

// Ottieni un timestamp e codice task per eventuali errori
$task = rand(10000, 99999);
$time = date('d-m-Y H:i:s');

// Carica configurazione
require 'core.inc.php';

ignoraTransazione();

// Controlla che il server di cache sia vivo
if ( !$cache ) {
	echo "#{$task}, {$time}: Server di cache morto!\n";
	exit(1);
}

// Controlla se ci sono sessioni avviate
// e termina ritornando stato 0 (OK)
if ( $cache->get("gaia:mailer:lock") )
	exit(0);

// Imposta flag di esecuzione (non voglio)
// script contemporanei a questo, timeout 2 minuti
$cache->set        ('gaia:mailer:lock', true);
$cache->setTimeout ('gaia:mailer:lock', 120);

// Ottieni cursore alle prossime email da inviare
$coda = MEmail::inCoda()->limit($conf['batch_size']);

$ok = true;

// Per ogni comunicazione in copia
foreach ( $coda as $_comunicazione ) {

	// 10 minuti per botta!
	set_time_limit(600);

	$time = date('d-m-Y H:i:s');

	// Instanzia oggetto
	$_comunicazione = MEmail::object($_comunicazione);

	try {
		// Tenta l'invio della comunicazione
		if ( !$stato = (int) $_comunicazione->invia( function() use ($cache) {
			// Evita il timeout per altri 5 secondi
			$cache->setTimeout('gaia:mailer:lock', 15);

		}) ) {
			echo "#{$task}, {$time}: Invio non riuscito," .
			     " comunicazione {$_comunicazione}" .
				 " (stato {$stato})\n";
		}

	} catch ( Errore $e ) {
		echo "#{$task}, {$time}: Errore: {$e->messaggio}\n";

	}

	$ok &= (bool) $stato;


}

// Ok, rilascia blocco invio
$cache->delete('gaia:mailer:lock');

// Termina con lo stato corretto
exit((int) !$ok);
