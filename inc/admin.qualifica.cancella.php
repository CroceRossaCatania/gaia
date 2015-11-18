<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.qualifica&err');
$t = filter_input(INPUT_GET, "id");
$current = Qualifiche::id($t);
$current->cancella();

redirect('admin.qualifica&del');

?>
