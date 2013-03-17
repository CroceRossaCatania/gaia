<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$t = $_GET['id'];
$f = new Delegato($t);
$f->fine = time();

redirect('admin.Referenti&ok');
