<?php

/**
 * (c)2015 Croce Rossa Italiana
 */

set_time_limit(0);
ini_set('memory_limit', '2G');

paginaAdmin();


$n = 0;
$s = 0;
$anagrafiche = Utente::conta([]);
$volontari = Utente::filtra([
	['stato', VOLONTARIO]
]);

$sesso = [
	'M' =>	0,
	'F'	=>	0
];

$eta = [
	[[0, 	30],	0],
	[[30, 	41], 	0],
	[[41, 	51], 	0],
	[[51, 	66], 	0],
	[[66, 	999], 	0],
];

$anzianita = [
	[[0, 	 1],	0],
	[[1, 	 5],	0],
	[[5, 	10],	0],
	[[10, 	21],	0],
	[[21, 	30],	0],
	[[30, 	999],	0],
];

$ora = new DateTime();

foreach ( $volontari as $v ) {

	$ingresso = $v->ingresso();
	if ( !$ingresso ) {
		$s++;
		continue;
	}

	$n++;
	$sesso[Utente::sesso($v->codiceFiscale)]++;

	foreach ( $eta as &$_e ) {
		$min = $_e[0][0];
		$max = $_e[0][1];
		$e   = $v->eta();
		if ( $e >= $min && $e < $max ) {
			$_e[1]++;
		}
	}

	foreach ( $anzianita as &$_e ) {
		$min = $_e[0][0];
		$max = $_e[0][1];
		$diff = $ora->diff($ingresso);
		if ( $diff->y >= $min && $diff->y < $max ) {
			$_e[1]++;
		}
	}

}


?>

<h2>Statistiche</h2>

<pre>
Report creato il <?= $ora->format('d/m/Y \a\l\l\e H:i'); ?> 

N. di volontari ed aspiranti su Gaia: <?= $anagrafiche; ?>  
N. di volontari..: <?= ($n); ?>  
- Di cui uomini..: <?= $sesso['M']; ?>; 
- Di cui donne...: <?= $sesso['F']; ?>. 
(pi&ugrave; <?= $s; ?> senza appartenenza valida su Gaia per anzianit&agrave;)


Per fascia di et&agrave;
<?php foreach ( $eta as $f ) { ?>
- <?= $f[0][0]; ?> &lt;= et&agrave; &lt; <?= $f[0][1]; ?>: n. <?= $f[1]; ?> volontari;
<?php } ?>

Per anzianit&agrave;
<?php foreach ( $anzianita as $f ) { ?>
- <?= $f[0][0]; ?> &lt;= anzianit&agrave; &lt; <?= $f[0][1]; ?>: n. <?= $f[1]; ?> volontari;
<?php } ?>

</pre>