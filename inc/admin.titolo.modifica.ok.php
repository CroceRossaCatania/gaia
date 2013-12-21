<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.titoli&err');
$t = $_GET['id'];

$t = Titolo::id($t);
$t->tipo = $_POST['inputTipo'];
$t->nome = maiuscolo( $_POST['inputNome'] );
   
redirect('admin.titoli&mod');

?>
