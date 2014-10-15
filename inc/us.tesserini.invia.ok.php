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

if($t->stato != STAMPATO) { 
    redirect('us.tesserini&gia');
}

// mancano le email?
if($_POST["spedizione"] == true) {
    $t->stato = SPEDITO_COMITATO;
} else {
    $t->stato = SPEDITO_CASA;
}

$t->pConferma = $me;
$t->tConferma = time();

redirect('us.tesserini&spedito');
