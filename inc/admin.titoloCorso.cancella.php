<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.titoliCorsi&err');
$t = $_GET['id'];
$f = TitoloCorso::id($t);
$f->cancella();

redirect('admin.titoliCorsi&del');

?>
