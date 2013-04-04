<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPresidenziale();

$t     = $_GET['id'];
$t = new Riserva($t);

if (isset($_GET['si'])) {
    $v = $t->volontario()->id;
    $t->stato = RISERVA_OK;
    $t->pConferma = $me->id;
    $t->tConferma = time();
    /*$m = new Email('richiestaRiserva', 'Richiesta riserva approvata');
    $m->a = $a->volontario();
    $m->_NOME       = $a->volontario()->nome;
    $m-> _TIME = date('d-m-Y', $a->timestamp);
    $m->invia();*/
    
redirect('presidente.riserva&ok');  

}

if (isset($_GET['no'])) {
    $v = $t->volontario()->id;
    $t->nega($_POST['motivo']);
    /*$m = new Email('richiestaRiservaNegata', 'Richiesta riserva negata');
    $m->a = $a->volontario();
    $m->_NOME       = $a->volontario()->nome;
    $m-> _TIME = date('d-m-Y', $a->timestamp);
    $m-> _MOTIVO =$_POST['motivo'];
    $m->invia();*/
    
redirect('presidente.riserva&no');   
}
?>