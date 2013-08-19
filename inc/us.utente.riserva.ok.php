<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

$t = $_POST['inputVolontario'];
$t = new Volontario($t);
$m = $_POST['inputMotivo'];

 foreach ( $t->storico() as $app ) { 
                         if ($app->attuale()) 
                                    {
                             $c = $app;
                         }
                         } 

/*Avvio la procedura*/

        $t = new Riserva();
        $t->stato = RISERVA_INCORSO;
        $t->appartenenza = $c;
        $t->volontario = $t->id;
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
        
        redirect('us.dash&risok');
