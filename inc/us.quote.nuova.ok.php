<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$id = $_GET['id'];
$id = Volontario::by('id', $id);
$r = $_GET['radio'];

 foreach ( $id->storico() as $app ) { 
                         if ($app->attuale()) 
                                    {
                                $t = new Quota();
                                $t->volontario = $id;
                                $t->appartenenza = $app;
                                $time = DT::createFromFormat('d/m/Y', $_GET['inputData']);
                                $t->timestamp = $time->getTimestamp();
                                $t->tConferma = time();
                                $t->pConferma = $me;
                                if($r=="prima"){
                                    $t->quota = QUOTA_PRIMO;
                                }elseif($r == "rinnovo"){
                                    $t->quota = QUOTA_RINNOVO;
                                }elseif($r == "altro"){
                                    $t->quota = $_POST['importo'];
                                    $t->causale = $_POST['causale'];
                                }
                                
                                redirect('us.quoteNo&ok');
                         }
                         } 
                         
