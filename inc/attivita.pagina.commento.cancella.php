<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$a = $_GET['a'];

$n = Commento::filtra([['upCommento', $a]]);
foreach( $n as $_n){
    $x = new Commento($_n);
    $x->cancella();
}

$f = new Commento($a);
$a = $f->attivita;
$f->cancella();

redirect('attivita.pagina&a=' . $a);