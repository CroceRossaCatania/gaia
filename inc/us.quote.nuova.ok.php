<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$id = $_GET['id'];
$id = Volontario::id($id);
$r = $_GET['inputQuota'];

 foreach ( $id->storico() as $app ) { 
                         if ($app->attuale()) 
                                    {
                                $t = new Quota();
                                $t->appartenenza = $app;
                                $time = DT::createFromFormat('d/m/Y', $_GET['inputData']);
                                $t->timestamp = $time->getTimestamp();
                                $t->tConferma = time();
                                $t->pConferma = $me;
                                if($r==QUOTA_PRIMO){
                                    $t->quota = QUOTA_PRIMO;
                                    $s = QUOTA_PRIMO;
                                    $i = "Versamento quota iscrizione";
                                    $t->causale = $i;
                                }elseif($r == QUOTA_RINNOVO){
                                    $t->quota = QUOTA_RINNOVO;
                                    $s = QUOTA_RINNOVO;
                                    $i = "Versamento quota di rinnovo annuale";
                                    $t->causale = $i;
                                }elseif($r ==QUOTA_ALTRO){
                                    $t->quota = $_GET['inputImporto'];
                                    $t->causale = $_GET['inputCausale'];
                                    $s = $_GET['inputImporto'];
                                    $i = $_GET['inputCausale'];
                                    
                                }
                                
                                $p = new PDF('ricevutaquota', 'ricevuta.pdf');
                                $p->_COMITATO = $app->comitato()->locale()->nomeCompleto();
                                $p->_INDIRIZZO = $app->comitato()->locale()->formattato;
                                $iva = PIVA;
                                $p->_PIVA = $iva;
                                $p->_ID = $t;
                                $p->_NOME = $id->nome;
                                $p->_COGNOME = $id->cognome;
                                $p->_FISCALE = $id->codiceFiscale;
                                $p->_NASCITA = date('d/m/Y', $id->dataNascita);
                                $p->_LUOGO = $id->luogoNascita;
                                $p->_QUOTA = $s;
                                $p->_CAUSALE = $i;
                                $p->_LUOGO = $app->comitato()->locale()->comune;
                                $p->_DATA = date('d-m-Y', time());
                                $f = $p->salvaFile();                                
                                
                                /* Invio ricevuta all'utente */
                                
                                $m = new Email('ricevutaQuota', 'Ricevuta versamento Quota');
                                $m->a = $id;
                                $m->da = $me;
                                $m->_NOME       = $id->nome;
                                $m->allega($f);
                                $m->invia();
                                
                                redirect('us.quoteNo&ok');
                         }
                         } 
                         
