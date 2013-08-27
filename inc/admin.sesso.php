<?php 

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

set_time_limit(0);

$utenti = Utente::elencoID();

foreach ($utenti  as $u) {
	$utente = new Utente($u);
	echo(''.$utente->nome.' '.$utente->cognome);
	if (intval(substr($utente->codiceFiscale, 9, 2)) < 40){
		$utente->sesso = UOMO;
		echo(' UOMO ');
		$s = 1;
	}else{
		$utente->sesso = DONNA;
		echo(' DONNA ');
		$s = 0;
	}
	echo(' '.$utente->sesso);

	if ($utente->sesso != $s) {
		echo('<strong> ERRORE </strong>');
	}
	echo('<br>');
}

