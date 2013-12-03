<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata(false);

if ( !$me->consenso() ) {
	$me->consenso = time();
}

redirect('utente.privacy');