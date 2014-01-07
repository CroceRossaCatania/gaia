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
 foreach ( $me->storico() as $app ) { 
    if ($app->attuale()) {
        $c = $app;
    }
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

