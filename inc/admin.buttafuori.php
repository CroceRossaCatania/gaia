<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();

set_time_limit(0);

$n = 0;
foreach ( Sessione::elenco() as $s ) {
	$s->cancella();
	$n++;
}

if ( $cache )
	$cache->flushAll();


?>

<h2><?php echo $n; ?> sessioni cancellate.</h2>
<p>Tutti sono stati buttati fuori e la cache flushata.</p>

<p>... pure tu. <a href="?p=login">Spiacente</a>.</p>