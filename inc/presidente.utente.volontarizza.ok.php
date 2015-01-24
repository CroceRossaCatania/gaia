<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);
controllaParametri(['id']);

$id = $_GET['id']; 
$u = Utente::id($id);
proteggiDatiSensibili($u);

if($u->stato != PERSONA) {
    redirect('errore.permessi&cattivo');
}

$app = $u->appartenenzaAttuale();
$comitato = $app->comitato;

$inizio = DateTime::createFromFormat('d/m/Y', $_POST['dataInizio']);
if ( $inizio ) {
    $inizio = $inizio->getTimestamp();
    $app->fine = $inizio;
} else {
    $app->fine = 0;
}

$u->stato = VOLONTARIO;
$nuovaApp = new Appartenenza();
$nuovaApp->volontario = $u;
$nuovaApp->comitato = $comitato;
$nuovaApp->stato = MEMBRO_VOLONTARIO;
$nuovaApp->inizio = $inizio;
$nuovaApp->timestamp = time();
$nuovaApp->comferma = $me;

redirect("presidente.utente.visualizza&innalzato&id={$id}");
