<?php

paginaAdmin();

?>

<h2>Risolutore <a href="https://github.com/CroceRossaCatania/gaia/issues/2000" target="_new" title="#2000">Millennium Bug</a></h2>

<p>Questo script risolve il "Millennium bug" (issue #2000). In particolare:</p>
<ul>
	<li>Tutti i membri ordinari che sono stati inseriti presso i Comitati privati in seguito all'introduzione del nuovo Regolamento, vengono tradotti in Soci Sostenitori,</li>
	<li>Tutti i membri ordinari che sono stati inseriti presso i Comitati privati antecedentemente all'introduzione del nuovo Regolamento, vengono tradotti in Ex-Soci Ordinari.</li>
</ul>

<?php if (!isset($_POST['ok'])) { ?>
<form action="" method="POST">
	<button type="submit" name="ok" value="1" class="btn btn-danger btn-block">
		Avvia lo script
	</button>
</form>

<?php } else { ?>

	<hr />
	Log esecuzione:
	<pre>

<?php

$q = "
SELECT 
	anagrafica.id, appartenenza.id
FROM
	anagrafica, appartenenza
WHERE
	anagrafica.id = appartenenza.volontario
AND 
	appartenenza.stato = :stato
AND
	appartenenza.inizio <= :inizio
";
$q = $db->prepare($q);
$q->bindValue(':stato', MEMBRO_ORDINARIO);
$q->bindValue(':inizio', MILLENNIUM_TIMESTAMP);
$q->execute();

echo "Sono state aggiornate le seguenti appartenenze: \n\n(";

$n = 0;
while ( $r = $q->fetch(PDO::FETCH_NUM) ) {
	$app = Appartenenza::id($r[1]);
	$app->stato = MEMBRO_EXORDINARIO;
	echo "{$r[1]}, ";
	$n++;
}

echo ")\n\n";

echo "Aggiornate {$n} appartenenze.";





?>

	</pre>

<?php } ?> 



