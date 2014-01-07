<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'));
$a = $_GET['id'];

$n = Commento::filtra([['upCommento', $a]]);
foreach( $n as $_n){
    $x = Commento::id($_n);
    $x->cancella();
}

$f = Commento::id($a);
$a = $f->attivita;
$f->cancella();

redirect('attivita.scheda&id=' . $a);

?>
