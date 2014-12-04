<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata(false);

if ( !$me->consenso() ) {
	$me->consenso = time();
}
if ($me->stato == VOLONTARIO) {
	redirect('utente.privacy');
}
redirect('utente.me');

?>