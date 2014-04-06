<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();

controllaParametri(['id'], 'us.tesserini&err');

$t = TesserinoRichiesta::id($_POST['id']);
$u = $t->utente();

if(!$me->admin() && $me->delegazioneAttuale()->comitato() != $t->struttura()) {
    redirect('errore.permessi&cattivo');
}

if($t->stato != RICHIESTO) { 
    redirect('us.tesserini&gia');
}

// mancano le email?
if($_POST["stampa"] == true) {
    $t->stato = STAMPATO;
} else {
    if(!isset($_POST["inputMotivo"])) {
        redirect("us.tesserini.aggiorna&id={$t}&mot");
    }
    $t->stato = RIFIUTATO;
    $t->motivo = $_POST["inputMotivo"];
}

$t->pConferma = $me;
$t->tConferma = time();
$t->timestamp = time();

redirect('us.tesserini&stampato');
