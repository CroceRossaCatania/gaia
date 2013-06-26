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
                                $t->appartenenza = $app;
                                $time = DT::createFromFormat('d/m/Y', $_GET['inputData']);
                                $t->timestamp = $time->getTimestamp();
                                $t->tConferma = time();
                                $t->pConferma = $me;
                                if($r=="prima"){
                                    $t->quota = QUOTA_PRIMO;
                                    $s = QUOTA_PRIMO;
                                }elseif($r == "rinnovo"){
                                    $t->quota = QUOTA_RINNOVO;
                                    $s = QUOTA_RINNOVO;
                                }elseif($r == "altro"){
                                    $t->quota = $_POST['importo'];
                                    $t->causale = $_POST['causale'];
                                    $s = $_POST['causale'];
                                }
                                
                                $p = new PDF('ricevutaquota', 'ricevuta.pdf');
                                $p->_COMITATO = $app->comitato()->locale()->nomeCompleto();
                                $p->_INDIRIZZO = $app->comitato()->locale()->formattato;
                                $p->_PIVA = PIVA;
                                $p->_ID = $t;
                                $p->_NOME = $id->nome;
                                $p->_COGNOME = $id->cognome;
                                $p->_FISCALE = $id->codiceFiscale;
                                $p->_NASCITA = date('d/m/Y', $id->dataNascita);
                                $p->_LUOGO = $id->luogoNascita;
                                $p->_QUOTA = $s;
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
                         
