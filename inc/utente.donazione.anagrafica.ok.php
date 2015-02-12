<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('inputSangueGruppo'));

$p = DonazioneAnagrafica::filtra([['volontario',$me->id]]);
if ( $p ) {
	$p = new DonazioneAnagrafica();
	$p->volontario  = $me->id;
}

$p->sangue_gruppo   = normalizzaNome($_POST['sede']);
$p->fattore_rh = $_POST['inputFattoreRH'] ? normalizzaNome($_POST['inputFattoreRH']) : 0;
$p->fanotipo_rh = $_POST['inputFenotipoRH'] ? normalizzaNome($_POST['inputFenotipoRH']) : 0;
$p->kell = $_POST['inputKell'] ? normalizzaNome($_POST['inputKell']) : 0;

redirect('utente.donazioni&d=' . $t->tipo);
