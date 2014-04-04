<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'presidente.trasferimento&err');
$t = $_GET['id'];

$t = Trasferimento::id($t);
$t->cancella();

redirect('presidente.trasferimento&canc');
