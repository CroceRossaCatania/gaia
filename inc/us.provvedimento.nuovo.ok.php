<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

$parametri = array('inputVolontario', 'datainizio', 'datafine', 'inputMotivo', 'protNum', 'protData', 'inputTipo');
controllaParametri($parametri, 'us.dash&err');

if ( controlloData($_POST['datainizio']) )
 $inizio   = DateTime::createFromFormat('d/m/Y', $_POST['datainizio']);

if ( controlloData($_POST['datafine']) )
 $fine     = DateTime::createFromFormat('d/m/Y', $_POST['datafine']);

if ( controlloData($_POST['protData']) )
 $protData = DateTime::createFromFormat('d/m/Y', $_POST['protData']);

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

if ( $_POST['datainizio'] ) {
    if ( $inizio ) {
        $inizio = @$inizio->getTimestamp();
        $p->inizio = $inizio;
    } else {
        $p->inizio = 0;
    }
}

if ( $_POST['datafine'] ) {
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

redirect('us.dash&provok');

?>
