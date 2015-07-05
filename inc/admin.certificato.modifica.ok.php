<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.certificati&err');
$t = $_GET['id'];

$t = Certificato::id($t);
$t->nome = maiuscolo( $_POST['inputNome'] );
   
redirect('admin.certificati&mod');

?>
