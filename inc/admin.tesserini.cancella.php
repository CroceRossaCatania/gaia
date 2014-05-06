<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'us.dash&err');
$t = $_GET['id'];

$t = TesserinoRichiesta::id($t);
$t->cancella();

redirect('us.tesserini&canc');

?>
