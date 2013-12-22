<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'));
$t=$_GET['id'];
$f = Persona::id($t);
$f->admin = '';
redirect('admin.admin&ok');

?>
