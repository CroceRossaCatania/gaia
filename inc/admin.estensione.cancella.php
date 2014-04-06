<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'presidente.estensione&err');
$e = $_GET['id'];

$e = Estensione::id($e);
$e->cancella();

redirect('presidente.estensione&canc');
