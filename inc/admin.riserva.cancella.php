<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'presidente.riserva&err');
$r = $_GET['id'];

$r = Riserva::id($r);
$r->cancella();

redirect('presidente.riserva&canc');
