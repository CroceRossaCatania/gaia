<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

$inizio = @DateTime::createFromFormat('d/m/Y', $_POST['datainizio']);
$fine = @DateTime::createFromFormat('d/m/Y', $_POST['datafine']);

if (@$fine->getTimestamp() < time() || (@$fine->getTimestamp() - @$inizio->getTimestamp()) > ANNO) {
    redirect('us.dash&riserrdate');
}

$t = $_POST['inputVolontario'];
$v = Volontario::id($t);
$m = $_POST['inputMotivo'];

$app = $v->appartenenzeAttuali(MEMBRO_VOLONTARIO)[0];

/*Avvio la procedura*/

$r = new Riserva();
$r->stato = RISERVA_INCORSO;
$r->appartenenza = $app->id;
$r->volontario = $v->id;
$r->motivo = $m;
$r->timestamp = time();                
if ( $_POST['datainizio'] ) {
    if ( $inizio ) {
        $inizio = @$inizio->getTimestamp();
        $r->inizio = $inizio;
    } else {
        $r->inizio = 0;
    }
}

if ( $_POST['datafine'] ) {
    if ( $fine ) {
        $fine = @$fine->getTimestamp();
        $r->fine = $fine;
    } else {
        $r->fine = 0;
    }
}

redirect('us.dash&risok');

?>
