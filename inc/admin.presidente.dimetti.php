<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$t = $_GET['id'];
$t = new Delegato($t);
$t->fine = time();


redirect('admin.presidenti&ok');
