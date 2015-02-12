<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('inputSangueGruppo'));

$p = new DonazioneAnagrafica();
$p->volontario  = $me->id;
$p->sangue_gruppo   = normalizzaNome($_POST['sede']);
$inputFattoreRH = $_POST['inputFattoreRH'] ? normalizzaNome($_POST['inputFattoreRH']) : null;
$p->__set('fattore_rh',$inputFattoreRH);
$inputFenotipoRH = $_POST['inputFenotipoRH'] ? normalizzaNome($_POST['inputFenotipoRH']) : null;
$p->__set('fanotipo_rh',$inputFenotipoRH);
$kell = $_POST['inputKell'] ? normalizzaNome($_POST['inputKell']) : null;
$p->__set('kell',$kell);

redirect('utente.donazioni&ok&d=' . $t->tipo);
