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
$task = getmypid();
$time = date('d-m-Y H:i:s');

// Carica configurazione
require 'core.inc.php';

define('VERBOSE', true);

function processRunning($pid) {
    exec('ps '.$pid,$output,$result);
    if( count( $output ) == 2 ) {
        return true;
    }
    return false;
}

// Lockfile
define('LOCKFILE', 	'upload/log/mail.lock');
function lock() 	{ file_put_contents(LOCKFILE, getmypid()); }
function unlock() 	{ file_put_contents(LOCKFILE, 0); }
function running() 	{ return (bool) file_exists(LOCKFILE) && (int) file_get_contents(LOCKFILE) && processRunning((int) file_get_contents(LOCKFILE)); }
function locked() 	{ return (bool) file_exists(LOCKFILE) && running(); }

ignoraTransazione();

// Controlla se ci sono sessioni avviate
// e termina ritornando stato 0 (OK)
if ( locked() ) {
	echo "#{$task}, {$time} ha provato a partire, ma ha trovato un file di lock ed un processo attivo.\n";
	exit(0);
}

if ( !running() ) {
	$expid = (int) file_get_contents(LOCKFILE);
	if ( $expid != 0 ) {
		echo "#{$task}, {$time}  WARNING  ha trovato un file di lock, ma il processo (#{$expid}) è morto prematuramente,\n";
		echo "#{$task}, {$time}           sta quindi ignorando il file di lock.\n";
	}
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

	try {
		// Tenta l'invio della comunicazione
		if ( !$stato = (int) $_comunicazione->invia( function() use ($cache, $task, $time, $_comunicazione) {

			$now = date('d-m-Y H:i:s');
			echo "#{$task}, {$time}, {$now}, inviato un messaggio per {$_comunicazione}\n";

		}) ) {
			$now = date('d-m-Y H:i:s');
			echo "#{$task}, {$time}, {$now}: Invio non riuscito," .
			     " comunicazione {$_comunicazione}" .
				 " (stato {$stato})\n";
		}

	} catch ( Errore $e ) {
		$now = date('d-m-Y H:i:s');
		echo "#{$task}, {$time}, {$now}: Errore: {$e->messaggio}\n";

	}

	$ok &= (bool) $stato;


}

// Ok, rilascia blocco invio
echo "#{$task}, {$time} ha terminato, rilascia il file di lock.\n";
unlock();

// Termina con lo stato corretto
exit((int) !$ok);
