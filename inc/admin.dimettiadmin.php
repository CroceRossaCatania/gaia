<?php

/*
 * ©2012 Croce Rossa Italiana
 */
$t=$_GET['id'];
$f = new Persona($t);
$f->admin = 'NULL';
redirect('admin&ok');
