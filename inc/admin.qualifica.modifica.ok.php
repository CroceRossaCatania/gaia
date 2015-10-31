<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.qualifica&err');
$t = filter_input(INPUT_POST, "id");
$t = filter_input(INPUT_POST, "id");

$t = Qualifica::id($t);
$t->tipo = $_POST['inputTipo'];
$t->nome = maiuscolo( $_POST['inputNome'] );
   
redirect('admin.qualifica&mod');

?>
