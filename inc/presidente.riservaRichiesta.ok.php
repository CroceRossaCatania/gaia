<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$t     = $_GET['id'];


                                    $a = new Riserva($t);
                                    $a->protNumero = $_POST['numprotocollo'];
                                    $protData = @DateTime::createFromFormat('d/m/Y', $_POST['dataprotocollo']);
                                    $protData = @$protData->getTimestamp();
                                    $a->protData = $protData;
                                    /*$m = new Email('richiestaTrasferimentoprot', 'Richiesta trasferimento Protocollata: ' . $a->comitato()->nome);
                                    $m->a = $a->volontario();
                                    $m->_NOME       = $a->volontario()->nome;
                                    $m->_COMITATO   = $a->comitato()->nome;
                                    $m-> _TIME = date('d-m-Y', $a->protData);
                                    $m-> _NUM = $a->protNumero;
                                    $m->invia();*/
                                    
redirect('presidente.riserva&prot');   
?>