<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$t = $_GET['oid'];
$t = GeoPolitica::daOid($t);
$t->cancella();
redirect('admin.comitati&del');
