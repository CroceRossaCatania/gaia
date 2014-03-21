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

if($u->delegazioni()
    or $u->attivitaReferenziate()
    or $u->corsiBaseDiretti()
    or $u->areeDiResponsabilita()) {
    redirect("presidente.utente.visualizza&roba&id={$id}");   
}

if ($u->stato == VOLONTARIO 
    and $u->appartenenzaAttuale()->stato == MEMBRO_VOLONTARIO) {
    foreach ($u->appartenenze() as $a) {
        if ($a->stato == MEMBRO_VOLONTARIO && $a->attuale()) {
            $a->stato = MEMBRO_ORDINARIO;
        } else {
            $a->cancella();
        }
    }
}

$u->stato = PERSONA;

redirect("presidente.utente.visualizza&declassato&id={$id}")

?>
