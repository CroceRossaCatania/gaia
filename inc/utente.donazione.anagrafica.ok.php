<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('inputSangueGruppo'));

$p = new DonazioneAnagrafica();
$p->volontario  = $me->id;
$p->sangue_gruppo   = normalizzaNome($_POST['sede']);
$p->fattore_rh = $_POST['inputFattoreRH'] ? normalizzaNome($_POST['inputFattoreRH']) : null;
$p->fanotipo_rh = $_POST['inputFenotipoRH'] ? normalizzaNome($_POST['inputFenotipoRH']) : null;
$p->kell = $_POST['inputKell'] ? normalizzaNome($_POST['inputKell']) : null;

redirect('utente.donazioni&ok&d=' . $t->tipo);
