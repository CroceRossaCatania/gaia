<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$t = $_GET['id'];
$f = new Delegato($t);
$f->cancella();

redirect('presidente.referenti&ok');
