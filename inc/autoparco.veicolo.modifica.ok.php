<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);
/* Ulteriore controllo se non sono resp locale o superiore non posso aggiungere veicolo */

/* da ripristinare al momento proviamo senza pian piano si sistemano
$parametri = array('inputNome', 'inputTipo');
controllaParametri($parametri, 'autoparco.veicoli&err');*/

$id = $_GET['id'];
$t = new Veicolo($id);

$t->targa 					= maiuscolo($_POST['inputTarga']);
$t->libretto 				= maiuscolo( $_POST['inputLibretto'] );
$t->telaio 					= $_POST['inputTelaio'];
$primaImmatricolazione = @DateTime::createFromFormat('d/m/Y', $_POST['inputPrimaImmatricolazione']);
$primaImmatricolazione = @$primaImmatricolazione->getTimestamp();
$t->primaImmatricolazione 	= $primaImmatricolazione;
$t->cognome 				= maiuscolo( $_POST['inputCognome'] );
$t->nome 					= maiuscolo( $_POST['inputNome'] );
$t->indirizzo 				= $_POST['inputIndirizzo'];
$t->anteriori 				= $_POST['inputAnt'];
$t->posteriori 				= $_POST['inputPost'];
$t->altAnt 					= $_POST['inputAltAnt'];
$t->altPost 				= $_POST['inputAltPost'];
$t->lunghezza 				= $_POST['inputLunghezza'];
$t->larghezza 				= $_POST['inputLarghezza'];
$t->sbalzo                  = $_POST['inputSbalzo'];
$t->tara 					= $_POST['inputTara'];
$t->marca 					= $_POST['inputMarca'];
$t->tipo 					= $_POST['inputTipo'];
$t->massa 					= $_POST['inputMaxMassa'];
$immatricolazione = @DateTime::createFromFormat('d/m/Y', $_POST['inputPrimaImmatricolazione']);
$immatricolazione = @$immatricolazione->getTimestamp();
$t->immatricolazione 		= $immatricolazione;
$t->categoria 				= $_POST['inputCategoria'];
$t->uso 					= $_POST['inputUso'];
$t->carrozzeria 			= $_POST['inputCarozzeria'];
$t->omologazione 			= $_POST['inputOmologazione'];
$t->assi 					= $_POST['inputAssi'];
$t->cilindrata 				= $_POST['inputCilindrata'];
$t->potenza 				= $_POST['inputPotenza'];
$t->alimentazione 			= $_POST['inputAlimentazione'];
$t->posti 					= $_POST['inputPosti'];
$t->regime 					= $_POST['inputRegime'];
$t->tInserimento 			= time();
$t->pInserimento 			= $me;
$t->stato 					= $_POST['inputStato'];
$t->intervalloRevisione 	= $_POST['inputintervalloRevisione'];

if ( $stato == VEI_FUORIUSO ) {
	$t->tFuoriuso = time();
	$t->pFuoriuso = $me;
}

/* aggiungere comitato cambio per admin*/

redirect('autoparco.veicoli&new');

?>
