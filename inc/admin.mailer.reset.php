<?php

paginaAdmin();

$time = time();
// 15 gg in secondi sono 1296000
$time -= 30 * 24 * 60 * 60; 
$q = $db->query("SELECT id, COUNT(id), oggetto, timestamp FROM email, email_destinatari WHERE inviato is NULL AND email_destinatari.email = id AND timestamp >= {$time} GROUP BY email.id");

$res = $q->fetchAll();


foreach ($res as $mailBrutta) {
	if ($mailBrutta["COUNT(id)"] <= 1) {
		continue;
	}
	$tot++;
	$totMail += $mailBrutta["COUNT(id)"];
	$id = $mailBrutta["id"];
	$q = "UPDATE email SET invio_terminato = NULL WHERE id=\"{$id}\"";
	$r = (int) $db->exec($q);
	$t = date( "d/m/Y H:i:s", $mailBrutta["timestamp"]);
	echo "{$id} - oggetto: {$mailBrutta['oggetto']} inviata in data {$t} resettato {$r} ({$mailBrutta['COUNT(id)']} destinatari erano bloccati)<br />";

}

echo "<h2>{$tot} messaggi sbloccati. ({$totMail} mails)</h2>";