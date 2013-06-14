<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$id = $_GET['id'];
$id = Volontario::by('id', $id);

 foreach ( $id->storico() as $app ) { 
                         if ($app->attuale()) 
                                    {
                                $t = new Quota();
                                $t->volontario = $id;
                                $t->appartenenza = $app;
                                $time = DT::createFromFormat('d/m/Y', $_GET['inputData']);
                                $t->timestamp = $time->getTimestamp();
                                $t->tconferma = time();
                                $t->pConferma = $me;
                                redirect('us.quoteNo&ok');
                         }
                         } 
                         
