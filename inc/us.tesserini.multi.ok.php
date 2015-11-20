<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();

set_time_limit(0);

if (!($tesserini = json_decode($sessione->selezioneTesserini))) {
    redirect('us.tesserini');
}


switch ( $sessione->operazioneTesserini ) {
	case 'lavora':
		$lavora = true;
		$scarica = false;
		break;
	case 'scarica':
		$lavora = false;
		$scarica = true;
		break;
	case 'lavora-scarica':
		$lavora = $scarica = true;
		break;
	default:
		redirect('errore.permessi&cattivo');
		break;
}

$sessione->selezioneTesserini = null;
$sessione->operazioneTesserini = null;
$n = count($tesserini);

if ( $scarica ) {
	$urls = [];
}

foreach ( $tesserini as $t ) {

	$t = TesserinoRichiesta::id($t);

	set_time_limit(0);

	if ( $lavora ) {

		if ( $t->stato != RICHIESTO )
			continue;

		$t->stato = STAMPATO;
		$t->pConferma = $me;
		$t->tConferma = time();

	}

	if ( $scarica ) { 
		$urls[] = "/?p=us.tesserini.p&download&id={$t->id}";
	}

}

if ( $scarica ) {
	$sessione->tesserini = json_encode($urls);
	redirect("us.tesserini.multi.download");
	
} else {
	redirect("us.tesserini&multi={$n}");

}

$zip->download();
