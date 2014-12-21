<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.donazioni&err');
$t = $_GET['id'];

$t = Donazione::id($t);
$t->tipo = $_POST['inputTipo'];
$t->nome = maiuscolo( $_POST['inputNome'] );
   
redirect('admin.donazioni&mod');

?>
