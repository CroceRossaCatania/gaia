<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$t = $_GET['id'];
$f = Delegato::id($t);
$f->cancella();

redirect('presidente.referenti&ok');
