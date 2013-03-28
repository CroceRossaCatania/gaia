<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['id'];
$t = new TitoloPersonale($t);
$tipo = $t->titolo()->tipo;
$t->cancella();

if(isset($_GET['pre'])){
redirect('presidente.utenti');
}else{
redirect('utente.titoli&t=' . $tipo);    
}
