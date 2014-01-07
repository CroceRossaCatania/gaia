<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.presidenti&err');
$t = $_GET['id'];
$t = Delegato::id($t);
$t->fine = time();


redirect('admin.presidenti&ok');

?>
