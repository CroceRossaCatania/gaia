<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

$id = $_POST['idTitolo'];

$t = new Titolo($id);

if ($me->haTitolo($t)) { redirect('titoli&gia&t=' . $t->tipo); }

$p = new TitoloPersonale();
$p->volontario  = $me->id;
$p->titolo      = $t->id;

if ( $_POST['dataInizio'] ) {
    $inizio = DateTime::createFromFormat('d/m/Y', $_POST['dataInizio']);
    $inizio = $inizio->getTimestamp();
    $p->inizio = $inizio;
}

if ( $_POST['dataFine'] ) {
    $fine = DateTime::createFromFormat('d/m/Y', $_POST['dataFine']);
    $fine = $fine->getTimestamp();
    $p->fine = $fine;
}

if ( $_POST['luogo'] ) {
    $p->luogo = normalizzaNome($_POST['luogo']);
}

if ( $_POST['codice'] ) {
    $p->codice = normalizzaNome($_POST['codice']);
}

if ( !$conf['titoli'][$t->tipo][1] ) {
    $p->tConferma = time();
    $p->pConferma = $me->id;
}

redirect('titoli&t=' . $t->tipo);