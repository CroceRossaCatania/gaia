<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('inputSangueGruppo'));

$p = DonazioneAnagrafica::filtra([['volontario',$me->id]]);
if ( !count($p) ) {
	$p = new DonazioneAnagrafica();
	$p->volontario  = $me;
} else {
	$p = $p[0];
}

$p->sangue_gruppo   = normalizzaNome($_POST['inputSangueGruppo']);
$fattore_rh = $_POST['inputFattoreRH'] ? $_POST['inputFattoreRH'] : 0;
$p->fattore_rh = normalizzaNome($fattore_rh);
$fanotipo_rh = $_POST['inputFenotipoRH'] ? $_POST['inputFenotipoRH'] : 0;
$p->fanotipo_rh = normalizzaNome($fanotipo_rh);
$kell = $_POST['inputKell'] ? $_POST['inputKell'] : 0;
$p->kell = normalizzaNome($kell);

redirect('utente.donazioni&ok&d=' . $t->tipo);
