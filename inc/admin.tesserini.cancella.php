<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'us.dash&err');
$t = $_GET['id'];

$ordinario = "us.tesserini&canc";

$t = TesserinoRichiesta::id($t);

if($t->utente()->ordinario()){
    $ordinario = "us.tesserini.ordinari&canc";
}

$t->cancella();

redirect($ordinario);

?>
