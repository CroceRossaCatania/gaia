<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$a = $_GET['a'];
$app = Appartenenza::by('id', $a);
$v = $app->volontario;

$app = new Appartenenza($a);
$app->volontario  = $v;

if ( $_POST['dataInizio'] ) {
    $inizio = @DateTime::createFromFormat('d/m/Y', $_POST['dataInizio']);
    if ( $inizio ) {
        $inizio = @$inizio->getTimestamp();
        $app->inizio = $inizio;
    } else {
        $app->inizio = 0;
    }
}

if ( $_POST['dataFine'] ) {
    $fine = @DateTime::createFromFormat('d/m/Y', $_POST['dataFine']);
    if ( $fine ) {
        $fine = @$fine->getTimestamp();
        $app->fine = $fine;
    } else {
        $app->fine = 0;
    }
}

if ( $_POST['inputcomitato'] ) {
    $app->comitato = $_POST['inputComitato'];
}

redirect('presidente.utente.visualizza&id=' . $v);
