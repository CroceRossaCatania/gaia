<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$t = $_GET['id'];
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
        $t = new Reperibilita();
        $t->comitato = $c;
        $t->volontario = $me;
        $inizio = DT::createFromFormat('d/m/Y H:i', $_POST['inizio']);
        $fine = DT::createFromFormat('d/m/Y H:i', $_POST['fine']);
        $t->inizio  = $inizio->getTimestamp();
        $t->fine    = $fine->getTimestamp();
        $t->attivazione = $_POST['attivazione'];
        redirect('utente.reperibilita&ok');
