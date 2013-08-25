<?php 

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

foreach ( Persona::elenco() as $u ) {
	set_time_limit(0);
	if (intval(substr($r->codiceFiscale, 9, 2)) < 40){
		$u->sesso = UOMO;
	}else{
		$u->sesso = DONNA;
	}
}

redirect('utente.me');