<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaAttivita();

$e = ElementoRichiesta::by('id', $_GET['id']);
$r = $e->richiesta();
$t = $r->turno();
$e->cancella();

if (!$r->elementi()){
	$r->cancella();
}

redirect("attivita.richiesta.turni&del&id={$t}");