<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['id'];
$t = new TitoloPersonale($t);
$v = $t->volontario();
$tipo = $t->titolo()->tipo;
$t->cancella();

if(isset($_GET['pre'])){
    redirect('presidente.utente.visualizza&id='.$v->id);
}else{
    redirect('utente.titoli&t=' . $tipo);    
}
