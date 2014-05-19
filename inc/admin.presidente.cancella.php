<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.presidenti&err');
$t = $_GET['id'];
$t = Delegato::id($t);
$t->cancella();

redirect('admin.presidenti&ok');

?>
