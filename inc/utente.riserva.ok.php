<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
richiediComitato();

$parametri = array('id', 'inputMotivo', 'datainizio', 'datafine');
controllaParametri($parametri);

$t = $_GET['id'];
$m = $_POST['inputMotivo'];
$c = $me->appartenenzaAttuale();

/* Evita richieste doppie se già riserva in sospeso o autorizzata */
if ($me->unaRiservaInSospeso() || $me->inRiserva()){
	redirect('utente.riserva&gia');
}

$inizio = DT::daFormato($_POST['datainizio']);
$fine = DT::daFormato($_POST['datafine']);

if (!$inizio || !$fine) {
    redirect('utente.riserva&err');
}

/*Avvio la procedura*/
$t = new Riserva();
$t->stato = RISERVA_INCORSO;
$t->appartenenza = $c;
$t->volontario = $me->id;
$t->motivo = $m;
$t->timestamp = time();                
$t->inizio = $inizio->getTimestamp();
$t->fine = $fine->getTimestamp();

$sessione->inGenerazioneRiserva = time();

redirect('presidente.riservaRichiesta.stampa&id=' . $t);