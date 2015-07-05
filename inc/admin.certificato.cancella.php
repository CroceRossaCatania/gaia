<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.certificati&err');
$t = $_GET['id'];
$f = Certificato::id($t);
$f->cancella();

redirect('admin.certificati&del');

?>
