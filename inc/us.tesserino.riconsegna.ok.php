<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

controllaParametri(array('id'));
$id = $_GET['id'];
$u = Utente::id($id);
$t = TesserinoRichiesta::filtra([
    ['volontario',      $u],
    ['stato',           INVALIDATO]],
    'tConferma DESC'
);
$t = $t[0];

$t->pRiconsegnato = $me;

if ( $_POST['inputData'] ) {
    $riconsegna = @DateTime::createFromFormat('d/m/Y', $_POST['inputData']);
    if ( $riconsegna ) {
        $riconsegna = $riconsegna->getTimestamp();
        $t->tRiconsegnato = $riconsegna;
    } else {
        redirect('us.tesserini.noRiconsegnati&err');
    }
}

redirect('us.tesserini.noRiconsegnati&ok');