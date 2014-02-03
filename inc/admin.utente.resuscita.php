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

if ($u->stato == PERSONA
    and $u->ultimaAppartenenza(MEMBRO_DIMESSO)) {

    $u->stato = VOLONTARIO;
    $a = $u->ultimaAppartenenza(MEMBRO_DIMESSO);
    $a->stato = MEMBRO_VOLONTARIO;
    $a->fine = 0;

    $d = Dimissione::by('appartenenza', $a->id);
    $d->cancella();

}

redirect("presidente.utenti");

?>
