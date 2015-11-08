<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();
controllaParametri(['id']);

$admin = $me->admin();

$lezione = Lezione::id($_POST['id']);
$corso = $lezione->corso();

paginaCorsoBase($corso);

$partecipazioni = $corso->partecipazioni(ISCR_CONFERMATA);
foreach ( $partecipazioni as $part ) { 
    $iscritto = $part->utente(); 
    $assenza = AssenzaLezione::filtra([['utente', $iscritto], ['lezione', $lezione]])[0];
    if($_POST["assenza_{$iscritto}"] == 1 && $assenza) {
        $assenza->cancella();
    } elseif($_POST["assenza_{$iscritto}"] == 2 && !$assenza) {
        $assenza = new AssenzaLezione();
        $assenza->utente = $iscritto;
        $assenza->lezione = $lezione;
        $assenza->pConferma = $me;
        $assenza->tConferma = time();
    }
}

redirect("formazione.corsibase.lezioni&id={$corso}&assenze");

?>
