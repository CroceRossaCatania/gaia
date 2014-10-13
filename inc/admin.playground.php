<?php

paginaAdmin();

?>
<h2>Playground</h2>
<pre>
<?php

$query = "
			SELECT 	aspiranti.utente,
					COUNT(corsibase.geo),
					aspiranti.id
			FROM  	aspiranti, corsibase
			WHERE  	utente NOT IN (
			    SELECT 	volontario
			    FROM	partecipazioniBase
			    WHERE	stato = 40
			)
			AND 		ST_DISTANCE( corsibase.geo, aspiranti.geo ) < aspiranti.raggio
			GROUP BY	aspiranti.utente
";
$query = $db->query($query);
while ( $r = $query->fetch(PDO::FETCH_NUM) ) {
	try {
		$u = Utente::id($r[0]);
	} catch ( Errore $e ) {
		$a = Aspirante::id($r[2]);
		$a->cancella();
		continue;
	}
	$y = $u->comuneResidenza;
	$u = $u->nomeCompleto();
	echo "{$u} ({$y}) ha {$r[1]} corsi nelle vicinanze...\n";
}







?>
</pre>

