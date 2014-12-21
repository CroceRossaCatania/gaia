<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.donazioni.sedi&err');
$t = $_GET['id'];
$f = DonazioneSedi::id($t);
$f->cancella();

redirect('admin.donazioni.sedi&del');

?>
