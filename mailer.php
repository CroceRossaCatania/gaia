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

define('VERBOSE', true);

// Lockfile
define('LOCKFILE', 	'upload/log/mail.lock');
function lock() 	{ file_put_contents(LOCKFILE, time()); }
function unlock() 	{ file_put_contents(LOCKFILE, 0); }
function locked() 	{ return (bool) file_exists(LOCKFILE) && file_get_contents(LOCKFILE); }

ignoraTransazione();

// Controlla se ci sono sessioni avviate
// e termina ritornando stato 0 (OK)
if ( locked() ) {
	echo "#{$task}, {$time} ha provato a partire, ma ha trovato un file di lock.\n";
	exit(0);
}

echo "#{$task}, {$time} sta partendo, ha creato un file di lock.\n";
// Imposta flag di esecuzione (non voglio)
lock();

// Ottieni cursore alle prossime email da inviare
$coda = MEmail::inCoda($conf['batch_size']);

$ok = true;

// Per ogni comunicazione in copia
foreach ( $coda as $_comunicazione ) {

	// 10 minuti per botta!
	set_time_limit(600);

	$time = date('d-m-Y H:i:s');

	try {
		// Tenta l'invio della comunicazione
		if ( !$stato = (int) $_comunicazione->invia( function() use ($cache, $task, $time, $_comunicazione) {

			echo "#{$task}, {$time} inviato un messaggio per {$_comunicazione}\n";

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
echo "#{$task}, {$time} ha terminato, rilascia il file di lock.\n";
unlock();

// Termina con lo stato corretto
exit((int) !$ok);
