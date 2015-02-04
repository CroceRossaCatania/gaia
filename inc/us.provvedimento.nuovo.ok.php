<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

$parametri = array('inputVolontario', 'dataInizio', 'dataFine', 'inputMotivo', 'protNum', 'protData', 'inputTipo');
controllaParametri($parametri, 'us.dash&err');

if ( DT::controlloData($_POST['dataInizio']) && 
     DT::controlloData($_POST['dataFine']) &&
     DT::controlloData($_POST['protData']) ) {
 $inizio   = DateTime::createFromFormat('d/m/Y', $_POST['dataInizio']);
 $fine     = DateTime::createFromFormat('d/m/Y', $_POST['dataFine']);
 $protData = DateTime::createFromFormat('d/m/Y', $_POST['protData']);

}else{

    redirect('us.dash&date');
}

if ( @$fine->getTimestamp() < @$inizio->getTimestamp() ) {
    redirect('us.dash&date');
}

$v = Volontario::id($_POST['inputVolontario']);
$motivo = $_POST['inputMotivo'];

/*Avvio la procedura*/

$p = new Provvedimento();
$p->volontario   = $v->id;
$p->tipo         = $_POST['inputTipo'];
$p->appartenenza = $v->appartenenzaAttuale();
$p->motivo       = $motivo;    
$p->pConferma    = $me;
$p->tConferma    = time();
$p->protNumero   = $_POST['protNum']; 

if ( $_POST['dataInizio'] ) {
    if ( $inizio ) {
        $inizio = @$inizio->getTimestamp();
        $p->inizio = $inizio;
    } else {
        $p->inizio = 0;
    }
}

if ( $_POST['dataFine'] ) {
    if ( $fine ) {
        $fine = @$fine->getTimestamp();
        $p->fine = $fine;
    } else {
        $p->fine = 0;
    }
}

if ( $_POST['protData'] ) {
    if ( $protData ) {
        $protData = @$protData->getTimestamp();
        $p->protData = $protData;
    } else {
        $p->protData = 0;
    }
}

if ($_POST['inputTipo'] == PROVV_ESPULSIONE){
    //dimissione automatica del volontario
    $v->dimettiVolontario(DIM_ESPULSIONE, $motivo, $me, $p->inizio);
}

try{
    $m = new Email('provvedimento', 'Provvedimento disciplinare');
    $m->da             = $me;
    $m->a              = $v;
    $m->_NOME          = $v->nomeCompleto();
    $m->_PROVVEDIMENTO = $conf['provvedimenti'][$_POST['inputTipo']];
    $m->_MOTIVO        = $motivo;
    $m->_DATA          = $p->inizio;
    $m->_PROTNUM       = $p->protNumero;
    $m->invia();
}catch (Exception $e){

}

redirect('us.dash&provok');
