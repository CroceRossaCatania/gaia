<?php 

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

foreach ( Utente::elenco() as $u ) {
	set_time_limit(0);
	$r = new Utente($u);
	if (intval(substr($r->codiceFiscale, 9, 2)) < 40){
		$r->sesso = UOMO;
	}else{
		$r->sesso = DONNA;
	}
}

redirect('utente.me');