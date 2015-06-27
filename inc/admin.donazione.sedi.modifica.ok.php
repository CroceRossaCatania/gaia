<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.donazioni.sedi&err');
$t = $_GET['id'];

$t = DonazioneSede::id($t);
$t->tipo = $_POST['inputTipo'];
$t->regione = $_POST['inputRegione'];
$t->provincia = $_POST['inputProvincia'];
$t->citta = $_POST['inputCitta'];
$t->nome = $_POST['inputNome'];
   
redirect('admin.donazioni.sedi&mod');

?>
