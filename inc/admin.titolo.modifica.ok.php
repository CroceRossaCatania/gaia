<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$t = $_GET['id'];

$t = Titolo::id($t);
$t->tipo = $_POST['inputTipo'];
$t->nome = maiuscolo( $_POST['inputNome'] );
   
redirect('admin.titoli&mod');

?>
