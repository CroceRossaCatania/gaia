<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE, APP_OBIETTIVO]);

$parametri = ['inputSangueGruppo', 'id'];
controllaParametri($parametri);

$f = $_GET['id']; 
$v= Volontario::id($f);
$p = DonazioneAnagrafica::by('volontario', $v->id);
if ( !$p ) {
	$p = new DonazioneAnagrafica;
	$p->volontario  = $v;
}

$p->sangue_gruppo   = normalizzaNome($_POST['inputSangueGruppo']);
$fattore_rh = $_POST['inputFattoreRH'] ? $_POST['inputFattoreRH'] : 0;
$p->fattore_rh = normalizzaNome($fattore_rh);
$fanotipo_rh = $_POST['inputFenotipoRH'] ? $_POST['inputFenotipoRH'] : 0;
$p->fanotipo_rh = normalizzaNome($fanotipo_rh);
$kell = $_POST['inputKell'] ? $_POST['inputKell'] : 0;
$p->kell = normalizzaNome($kell);
$codice_sit = $_POST['inputCodiceSIT'] ? $_POST['inputCodiceSIT'] : 0;
$p->codice_sit = normalizzaNome($codice_sit);
$sede_sit = $_POST['inputSedeSIT'] ? $_POST['inputSedeSIT'] : 0;
$p->sede_sit = normalizzaNome($sede_sit);

redirect('presidente.utente.visualizza&id=' . $v);
