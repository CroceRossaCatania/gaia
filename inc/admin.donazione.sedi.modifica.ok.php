<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.donazioni.sedi&err');
$t = $_GET['id'];

$t = DonazioneSede::id($t);
$t->tipo = $_POST['inputTipo'];
$t->nome = $_POST['inputNome'];
$t->provincia = $_POST['inputProvincia'];
$t->regione = $_POST['inputRegione'];
   
redirect('admin.donazioni.sedi&mod');

?>
