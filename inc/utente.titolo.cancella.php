<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['id'];
$t = TitoloPersonale::id($t);
$v = $t->volontario();
$tipo = $t->titolo()->tipo;
$t->cancella();

if(isset($_GET['pre'])){
    redirect('presidente.utente.visualizza&id='.$v->id);
}else{
    redirect('utente.titoli&t=' . $tipo);    
}
