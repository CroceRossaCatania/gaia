<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$t = $_GET['t'];
$id = $_GET['v']; 
$v= Volontario::id($id);
$tp = TitoloPersonale::id($t);
$tp = $tp->titolo;

$p = TitoloPersonale::id($t);
$p->volontario  = $v->id;
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

    $p->tConferma = time();
    $p->pConferma = $me->id;

redirect('presidente.utente.visualizza&id=' . $v->id);
