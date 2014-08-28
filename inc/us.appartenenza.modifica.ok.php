<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

controllaParametri(array('a'));

$a = $_GET['a'];
$app = Appartenenza::id($a);
$v = $app->volontario;


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

if ($me->admin() && $_POST['stato'] != $app->stato){
    $app->stato = $_POST['stato'];
}

redirect('presidente.utente.visualizza&id=' . $v);
