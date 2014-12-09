<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'));

$t = $_GET['id'];
$t = TitoloPersonale::id($t);
$v = $t->volontario();

if ( $me != $v )
	redirect('errore.permessi');

$tipo = $t->titolo()->tipo;
$t->cancella();

if(isset($_GET['pre'])){
    redirect('presidente.utente.visualizza&id='.$v->id);
} else {
    redirect('utente.titoli&t=' . $tipo);    
}
