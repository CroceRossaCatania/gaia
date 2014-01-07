<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

$parametri = array('datainizio', 'datafine', 'inputVolontario', 'inputMotivo');
controllaParametri($parametri, 'us.dash&err');

$inizio = DT::daFormato($_POST['datainizio']);
$fine = DT::daFormato($_POST['datafine']);

if (!$inizio || !$fine) {
    redirect('us.dash&riserrdate');
}

if ($fine->getTimestamp() < time() || ($fine->getTimestamp() - $inizio->getTimestamp()) > ANNO) {
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
$r->inizio = $inizio->getTimestamp();
$r->fine = $fine->getTimestamp();

redirect('us.dash&risok');

?>
