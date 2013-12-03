<?php 

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

set_time_limit(0);
$inizio = time();
$turni = Turno::elenco();
$i = 0;
foreach ($turni  as $turno) {
	$i++;
	echo "[",$i,"] ", $turno->nome,"<br/>";
	$turno->prenotazione = $turno->inizio;
}
$time = time()-$inizio;
echo "Finito! Ho sistemato: ", $i, " in: ", $time, " secondi";