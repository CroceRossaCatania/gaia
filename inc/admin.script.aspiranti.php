<?php

/**
 * (c)2014 Croce Rossa Italiana
 */


set_time_limit(0); // Abbi pieta' di me, interprete.

paginaAdmin();

$aspiranti = Aspirante::elenco();
echo count($aspiranti) . ' aspiranti da riraggiare: ';
foreach ( $aspiranti as $aspirante ) {
	$aspirante->trovaRaggioMinimo();
	echo '. ';
	flush();
}

echo 'ok!';

