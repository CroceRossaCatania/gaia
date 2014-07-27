<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

$parametri = ['inputCellulare'];
controllaParametri($parametri);

$cell       = normalizzaNome($_POST['inputCellulare']);
$cells      = normalizzaNome(@$_POST['inputCellulareServizio']);

if ( Utente::by('cellulare', $cell) || Utente::by('cellulare', $cells)) {
    redirect('utente.contatti&celle');
}

$me->cellulare           = $cell;
if($me->stato == VOLONTARIO) {
	$me->cellulareServizio   = $cells;
}

redirect('utente.contatti&cellok');
