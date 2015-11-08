<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.tipocorso&err');
$t = $_GET['id'];
$f = TipoCorso::id($t);
$f->cancella();

redirect('admin.tipocorso&del');

?>
