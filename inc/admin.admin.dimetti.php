<?php

/*
 * ©2013 Croce Rossa Italiana
 */
$t=$_GET['id'];
$f = new Persona($t);
$f->admin = '';
redirect('admin.admin&ok');
