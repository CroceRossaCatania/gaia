<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$id = $_POST['idTitolo'];
$f = $_GET['id']; 
$v= Volontario::by('id', $f);

$t = new Titolo($id);

if ($v->haTitolo($t)) { redirect('presidente.utente.visualizza&gia&id=' . $f ); }

$p = new TitoloPersonale();
$p->volontario  = $v->id;
$p->titolo      = $t->id;

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

redirect('presidente.utente.visualizza&id=' . $v);
