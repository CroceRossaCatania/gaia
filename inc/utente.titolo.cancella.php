<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'));

$t = $_GET['id'];
$t = TitoloPersonale::id($t);
$v = $t->volontario();

$tipo = $t->titolo()->tipo;

if ( $v->modificabileDa($me) || $me == $v->id ) {
	$t->cancella();
}else{
	redirect('errore.permessi');
}


if(isset($_GET['pre'])){
    redirect('presidente.utente.visualizza&id='.$v->id);
} else {
    redirect('utente.titoli&t=' . $tipo);    
}
