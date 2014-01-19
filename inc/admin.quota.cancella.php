<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'us.dash&err');
$q = $_GET['id'];

$q = Quota::id($q);
$q->cancella();

redirect('us.dash&canc');

?>
