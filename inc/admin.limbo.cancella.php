<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$v = $_GET['id'];

$f = TitoloPersonale::filtra([
    ['volontario', $v]
    ]);

foreach ($f as $_f) {
    $_f->cancella();
}


$t = Persona::id($v);
$t->cancella();
redirect('admin.limbo&ok');

?>