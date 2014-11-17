<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();

controllaParametri(['id'], 'us.tesserini&err');

$t = TesserinoRichiesta::id($_POST['id']);
$u = $t->utente();

$tipo = "us.tesserini";

if($u->ordinario()){
    $tipo = "us.tesserini.ordinari";
}

if(!$me->admin() && $me->delegazioneAttuale()->comitato() != $t->struttura()) {
    redirect('errore.permessi&cattivo');
}

if($t->stato != RICHIESTO) { 
    redirect($tipo.'&gia');
}

// mancano le email?
if($_POST["stampa"] == true) {
    $t->stato = STAMPATO;
    //Email stampato
} else {
    if(!isset($_POST["inputMotivo"])) {
        redirect("us.tesserini.aggiorna&id={$t}&mot");
    }
    
    $t->stato = RIFIUTATO;
    $t->motivo = $_POST["inputMotivo"];

    //Email tesserino rifiutato e motivo, avviso utente
    $m = new Email('richiestaTesserinoNegataUtente', 'Richiesta tesserino negata');
	$m->da      	= $me;
	$m->a       	= $u;
	$m->_NOME   	= $u->nome;
	$m->_MOTIVO 	= $_POST["inputMotivo"]);
	$m->accoda();

	//Email tesserino rifiutato e motivo, avviso presidente
    $m = new Email('richiestaTesserinoNegataPresidente', 'Richiesta tesserino negata');
	$m->da      	= $me;
	$m->a       	= $u->appartenenzaAttuale()->comitato()->primoPresidente();
	$m->_NOME   	= $u->nomeCompleto();
	$m->_MOTIVO 	= $_POST["inputMotivo"]);
	$m->accoda();

}

$t->pConferma = $me;
$t->tConferma = time();

redirect($tipo.'&stampato');
