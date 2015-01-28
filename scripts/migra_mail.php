<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

// Carica configurazione
require 'core.inc.php';

ignoraTransazione();

if ( php_sapi_name() !== 'cli' )
	die('No, amico. No.');

// Max mesi da importare
define('MAX_MESI', 3);

// Controlla che il server di cache sia vivo
if ( !$cache ) {
	echo "Server di cache morto!\n";
	exit(1);
}

set_time_limit(0);

$now = new DateTime();

echo "Ricerca email... ";
$e = $mdb->memail->find();
$n = $e->count();
echo "trovate {$n}.\n";

$inQ = $db->prepare("INSERT INTO email (id, invio_iniziato, invio_terminato, mittente_id, oggetto, corpo, timestamp) VALUES (:id, :invio_iniziato, :invio_terminato, :mittente_id, :oggetto, :corpo, :timestamp)");

$deQ = $db->prepare("INSERT INTO email_destinatari (email, dest, inviato, ok, errore) VALUES (:email, :dest, :inviato, :ok, :errore)");

$alQ = $db->prepare("INSERT INTO email_allegati (email, allegato_id, allegato_nome) VALUES (:email, :allegato_id, :allegato_nome)");


$i = 0; $j = 0; $l = 0; $dup = 0; $old++;
foreach ( $e as $m ) {

	$i++; 
	$t = round($i/$n*100, 2);
	echo "{$i} di {$n} ({$t}%) \tcod. {$m['_id']}\n";

	$dt = new DateTime();
	$sdt = $dt->setTimestamp($m['timestamp']);
	if ( !$sdt ) {
		$old++;
		echo "No timestamp\n";
		continue;
	}

	$diff = $now->diff($dt);
	if ($diff->m > MAX_MESI) {
		echo "Troppo vecchia.\n";
		$old++;
		continue;
	}

	// Inizio binding query di inserimento...

	$inQ->bindValue(':id',				$m['_id']);

	$iniziato = $m['invio']['iniziato'] ?
		$m['invio']['iniziato'] :
		null;

	$terminato = $m['invio']['terminato'] ?
		$m['invio']['terminato'] :
		null;

	$inQ->bindValue(':invio_iniziato',	$iniziato, PDO::PARAM_INT);
	$inQ->bindValue(':invio_terminato',	$terminato, PDO::PARAM_INT);

	$mittente = $m['invio']['mittente'] ? 
		$m['invio']['mittente']['id'] : 
		null;

	$inQ->bindValue(':mittente_id',	$mittente, PDO::PARAM_INT);
	$inQ->bindValue(':oggetto',		$m['oggetto']);
	$inQ->bindValue(':corpo',		$m['corpo']);
	$inQ->bindValue(':timestamp',	$m['timestamp'], PDO::PARAM_INT);

	echo "Email... ";
	$r = (int) $inQ->execute();

	if ( !$r ) {
		$dup++;
		echo "SKIP - Gia' inserito.\n";
		continue;
	}

	echo "OK. ";
	echo "Destt... ";
	if ( $m['destinatari'] ) {
		$db->beginTransaction();
		$deQ->bindValue(':email', $m['_id']);
		foreach ( $m['destinatari'] as $d ) {
			$j++;
			$deQ->bindValue(':dest', $d['id'], PDO::PARAM_INT);

			$inviato = $d['inviato'] ? 
				$d['inviato'] :
				null;

			$deQ->bindValue(':inviato', $inviato, PDO::PARAM_INT);

			$ok = isset($d['ok']) && $d['ok'] ?
				1 : 0;

			$errore = isset($d['errore']) && $d['errore'] ?
				$d['errore'] : "";

			$deQ->bindValue(':ok', $ok, PDO::PARAM_INT);
			$deQ->bindValue(':errore', $errore, PDO::PARAM_INT);

			$deQ->execute();
		}
		$db->commit();
	} else {
		$j++;
	}


	echo "OK. ";

	echo "All... ";
	if ( isset($m['allegati']) ) {
		$alQ->bindValue(':email', $m['_id']);
		foreach ( $m['allegati'] as $a ) {
			$l++;
			$alQ->bindValue(':allegato_id', $a['id']);
			$nome = isset($a['nome']) && $a['nome'] ?
				$a['nome'] : "";
			$alQ->bindValue(':allegato_nome', $nome);
			$alQ->execute();
		}
	}

	echo "OK. Fine.\n";

}

echo "\n";
echo "{$n} comunicazioni:\n";
echo "- {$j} email processate\n";
echo " - {$l} allegati processati.\n";
echo "- {$dup} comunicazioni saltate (esistenti)\n";
echo "- {$old} comunicazioni saltate (vecchie)\n";
