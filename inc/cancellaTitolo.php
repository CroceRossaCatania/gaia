<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['id'];
$t = new TitoloPersonale($t);
$tipo = $t->titolo()->tipo;
$t->cancella();

redirect('titoli&t=' . $tipo);
