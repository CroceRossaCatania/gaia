<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

controllaParametri(array('id'));

$t = $_GET['id'];
$f = Delegato::id($t);
$f->cancella();

redirect('presidente.referenti&ok');
