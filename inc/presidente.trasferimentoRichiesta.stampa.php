<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$f = $_GET['id'];
$t = Trasferimento::by('id', $f);
$cin = $t->comitato();
foreach ( $me->storico() as $app ) { 
                            if ($app->attuale()) 
                                    {
                                     if($app->stato == MEMBRO_VOLONTARIO){
                                     $cout = $app->comitato();
                                     $time = $app;
                                                                                                    }
                                    }
                                                            }

$p = new PDF('trasferimento', 'trasferimento.pdf');
$p->_COMITATOOUT = $cout->nome;
$p->_COMITATOIN = $cin->nome;
$p->_NOME = $t->volontario()->nome;
$p->_COGNOME = $t->volontario()->cognome;
$p->_LUOGO = $t->volontario()->comuneNascita;
$p->_DATA = date('d-m-Y', $t->volontario()->dataNascita);
$p->_ANNOCRI = date('d-m-Y', $time->inizio);
$p->_MOTIVO = $t->motivo;
$p->_TIME = date('d-m-Y', time());
$f = $p->salvaFile();
$f->download();

?>
