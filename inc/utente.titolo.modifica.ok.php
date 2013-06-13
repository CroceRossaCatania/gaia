<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['t'];
$tp = TitoloPersonale::by('id', $t);
$tp = $tp->titolo();

$p = new TitoloPersonale($t);
$p->volontario  = $me;
$p->titolo      = $tp;

if ( $_POST['dataInizio'] ) {
    $inizio = @DateTime::createFromFormat('d/m/Y', $_POST['dataInizio']);
    if ( $inizio ) {
        $inizio = @$inizio->getTimestamp();
        $p->inizio = $inizio;
    } else {
        $p->inizio = 0;
    }
}

if ( $_POST['dataFine'] ) {
    $fine = @DateTime::createFromFormat('d/m/Y', $_POST['dataFine']);
    if ( $fine ) {
        $fine = @$fine->getTimestamp();
        $p->fine = $fine;
    } else {
        $p->fine = 0;
    }
}

if ( $_POST['luogo'] ) {
    $p->luogo = normalizzaNome($_POST['luogo']);
}

if ( $_POST['codice'] ) {
    $p->codice = normalizzaNome($_POST['codice']);
}

redirect('utente.titoli&t=' . $tp->tipo);
