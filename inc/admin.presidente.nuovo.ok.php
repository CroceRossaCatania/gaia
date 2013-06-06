<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$t = $_GET['id'];
$c = $_POST['inputComitato'];
$comitato = new Comitato($c);

if ( $comitato->unPresidente() ) {
    if ($comitato->unPresidente()->attuale()){
    redirect('admin.presidenti&duplicato');
        }
}

/* Creo la nuova appartenenza... */
$a = new Delegato();
$a->volontario = $t;
$a->comitato    = $c;
$a->inizio      = time();
$a->fine        = PROSSIMA_SCADENZA;
$a->applicazione= APP_PRESIDENTE;
$a->conferma    = $me->id;
$a->timestamp   = time();
$a->pConferma =$me->id;
$a->tConferma=time();

redirect('admin.presidenti&new');
