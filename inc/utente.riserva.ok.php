<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$parametri = array('id', 'inputMotivo', 'datainizio', 'datafine');
controllaParametri($parametri);

$t = $_GET['id'];
$m = $_POST['inputMotivo'];
 foreach ( $me->storico() as $app ) { 
                         if ($app->attuale()) 
                                    {
                             $c = $app;
                         }
                         } 

/*Avvio la procedura*/

        $t = new Riserva();
        $t->stato = RISERVA_INCORSO;
        $t->appartenenza = $c;
        $t->volontario = $me->id;
        $t->motivo = $m;
        $t->timestamp = time();                
        if ( $_POST['datainizio'] ) {
            $inizio = @DateTime::createFromFormat('d/m/Y', $_POST['datainizio']);
            if ( $inizio ) {
                $inizio = @$inizio->getTimestamp();
                $t->inizio = $inizio;
            } else {
                $t->inizio = 0;
            }
        }

        if ( $_POST['datafine'] ) {
            $fine = @DateTime::createFromFormat('d/m/Y', $_POST['datafine']);
            if ( $fine ) {
                $fine = @$fine->getTimestamp();
                $t->fine = $fine;
            } else {
                $t->fine = 0;
            }
        }
        
        $sessione->inGenerazioneRiserva = time();
        redirect('presidente.riservaRichiesta.stampa&id=' . $t);
