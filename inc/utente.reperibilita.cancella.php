<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'));

$t = $_GET['id'];

$t = Reperibilita::id($t);

if ( $me->id != $t->volontario()->id )
	redirect('errore.permessi');

$t->fine    = time();
redirect('utente.reperibilita&del');