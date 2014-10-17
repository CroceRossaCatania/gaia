<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

paginaAdmin();


$aspiranti = Aspirante::elenco();
echo count($aspiranti) . ' aspiranti da riraggiare: ';
foreach ( $aspiranti as $aspirante ) {
	$aspirante->trovaRaggioMinimo();
	echo '.';
	flush();
}

echo 'ok!';

