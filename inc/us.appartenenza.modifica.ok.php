<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$a = $_GET['a'];
$app = Appartenenza::id($a);
$v = $app->volontario;

$app = Appartenenza::id($a);
$app->volontario  = $v;

if ( $_POST['dataInizio'] ) {
    $inizio = @DateTime::createFromFormat('d/m/Y', $_POST['dataInizio']);
    if ( $inizio ) {
        $inizio = @$inizio->getTimestamp();
        $app->inizio = $inizio;
    } else {
        $app->inizio = 0;
    }
}



if ( $_POST['inputComitato'] ) {
    $comitato     = $_POST['inputComitato'];
    $comitato     = Comitato::id($comitato);
    $app->comitato = $comitato->id;
}

redirect('presidente.utente.visualizza&id=' . $v);
