<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(['id']);

$id = $_GET['id']; 
$u = Utente::id($id);

if($u->admin) {
    redirect('errore.permessi&cattivo');
}

if($u->stato != PERSONA) {
    redirect('errore.permessi&cattivo');
}

$app = $u->appartenenzaAttuale();
$ora = time();
$comitato = $app->comitato;
$app->fine = $ora;
$u->stato = VOLONTARIO;
$nuovaApp = new Appartenenza();
$nuovaApp->volontario = $u;
$nuovaApp->comitato = $comitato;
$nuovaApp->stato = MEMBRO_VOLONTARIO;
$nuovaApp->inizio = $ora;
$nuovaApp->timestamp = time();
$nuovaApp->comferma = $me;


redirect("presidente.utente.visualizza&innalzato&id={$id}");

