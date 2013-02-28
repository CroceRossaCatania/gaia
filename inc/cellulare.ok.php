<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

$cell       = normalizzaNome($_POST['inputCellulare']);
$cells      = normalizzaNome(@$_POST['inputCellulareServizio']);

if ( Utente::by('cellulare', $cellulare) ) {
    redirect('cellulare&e');
}

$me->cellulare               = $cell;
$me->cellulareServizio   = $cells;

redirect('cellulare&ok');
