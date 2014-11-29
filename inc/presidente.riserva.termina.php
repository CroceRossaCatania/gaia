<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPresidenziale();

controllaParametri(array('id'), 'presidente.riserva&err');

$t = $_GET['id'];
$t = Riserva::id($t);
$t->termina();

redirect("presidente.utenti.riserve");
