<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

$parametri = array('inputCellulare', 'inputCellulareServizio');
controllaParametri($parametri);

$cell       = normalizzaNome($_POST['inputCellulare']);
$cells      = normalizzaNome(@$_POST['inputCellulareServizio']);

if ( Utente::by('cellulare', $cellulare) ) {
    redirect('utente.cellulare&e');
}

$me->cellulare           = $cell;
if($me->stato == VOLONTARIO) {
	$me->cellulareServizio   = $cells;
}

redirect('utente.cellulare&ok');
