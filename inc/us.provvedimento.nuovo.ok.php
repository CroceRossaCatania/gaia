<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

$parametri = array('inputVolontario', 'datainizio', 'datafine', 'inputMotivo', 'protNum', 'protData', 'inputTipo');
controllaParametri($parametri, 'us.dash&err');

$inizio   = @DateTime::createFromFormat('d/m/Y', $_POST['datainizio']);
$fine     = @DateTime::createFromFormat('d/m/Y', $_POST['datafine']);
$protData = @DateTime::createFromFormat('d/m/Y', $_POST['protData']);

if ( @$fine->getTimestamp() < @$inizio->getTimestamp() ) {
    redirect('us.dash&date');
}

$v = Volontario::id($_POST['inputVolontario']);
$m = $_POST['inputMotivo'];

/*Avvio la procedura*/

$p = new Provvedimento();
$p->volontario   = $v->id;
$p->tipo         = $_POST['inputTipo'];
$p->appartenenza = $v->appartenenzaAttuale();
$p->motivo       = $m;    
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
    $v->dimettiVolontario(DIM_ESPULSIONE, $m, $me, $p->inizio);
}

redirect('us.dash&provok');

?>
