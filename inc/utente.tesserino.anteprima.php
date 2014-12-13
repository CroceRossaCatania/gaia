<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();
controllaParametri(['id']);

$t = $_GET['id'];
$t = TesserinoRichiesta::id($t);

if ( $me != $t->utente() ){
	redirect('errore.permessi');
}

$t->generaTesserino()->anteprima();

redirect('errore.permessi');