<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'));
$a = $_GET['id'];
$f = Commento::id($a);
$n = Commento::filtra([['upCommento', $a]]);
$volontario = $f->volontario();

$m = new Email('commentoRimozione', 'Commento rimosso');
$m->da      	= $me;
$m->a       	= $volontario;
$m->_NOME   	= $volontario->nome;
$m->_COMMENTO 	= $f->commento;
$m->_REFERENTE 	= $me;
$m->accoda();

foreach( $n as $_n){
    $x = Commento::id($_n);
    $x->cancella();
}

$a = $f->attivita;
$f->cancella();

redirect('attivita.scheda&id=' . $a);

?>
