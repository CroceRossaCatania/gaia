<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$t = $_GET['id'];
$a = $_POST['inputApplicazione'];
$d = $_POST['inputDominio'];

/* Cerco appartenenza per determinare comitato */
$f = Appartenenza::filtra([
  ['volontario',    $t]
]);

/* Cerco l'attuale appartenenza,
 * creo su quella la nomina
 */
foreach ( $f as $_f ) {
    if ( $_f->attuale() ) {
        $d = new Delegato();
        $d->comitato = $_f->comitato;
        $d->volontario = $t;
        $d->applicazione = $a;
        $d->dominio =$d;
        $d->inizio = time();
        $d->fine = 0;
        $d->tConferma = time();
        $d->pConferma = $me->id;
    }
}

redirect('admin.Referenti&new');
