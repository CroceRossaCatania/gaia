<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$t = $_GET['id'];
$f = Comitato::by('id',$t);
$f->cancella();

redirect('admin.comitati&del');

?>
