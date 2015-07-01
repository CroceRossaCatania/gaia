<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.titoliCorsi&err');
$t = $_GET['id'];

$t = TitoloCorso::id($t);
$t->nome = maiuscolo( $_POST['inputNome'] );
   
redirect('admin.titoliCorsi&mod');

?>
