<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

if ( count($me->comitati()) > 1 ) {
   $c = $_POST['inputComitato'];
}else{
   foreach ( $me->storico() as $app ) { 
       if ($app->attuale()) 
       {
           $c = $app->comitato()->id;
       }
   } 
}

if ( !$c ){
	redirect('utente.reperibilita&comitato');
}

$inizio = DT::createFromFormat('d/m/Y H:i', $_POST['inizio']);
$fine   = DT::createFromFormat('d/m/Y H:i', $_POST['fine']);
$inizio = $inizio->getTimestamp();
$fine   = $fine->getTimestamp();

if ( !$inizio || !$fine || $inizio > $fine ){
	redirect('utente.reperibilita&date');
}

$t = new Reperibilita();
$t->comitato    = $c;
$t->volontario  = $me->id;
$t->inizio      = $inizio;
$t->fine        = $fine;
$t->attivazione = $_POST['attivazione'];

redirect('utente.reperibilita&ok');