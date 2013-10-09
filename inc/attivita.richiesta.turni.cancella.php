<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaAttivita();

$e = ElementoRichiesta::by('id', $_GET['id']);
$t = $e->richiesta()->turno();
$e->cancella();

redirect("attivita.richiesta.turni&del&id={$t}");