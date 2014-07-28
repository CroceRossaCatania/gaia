<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

/*
$parametri = array('inputTarga', 'inputLibretto', 'inputTelaio', 'inputPrimaImmatricolazione', 'inputCognome', 'inputNome', 'inputIndirizzo', 'inputAnt', 'inputPost');
controllaParametri($parametri, 'autoparco.veicoli&err');*/

$libretto = Veicolo::by('libretto', $_POST['inputLibretto']);

if (!$libretto){
    $t = new Veicolo();
    $t->comitato = $me->delegazioneAttuale()->comitato()->oid();
    $t->targa = maiuscolo($_POST['inputTarga']);
    $t->libretto = maiuscolo( $_POST['inputLibretto'] );
    $t->telaio = $_POST['inputTelaio'];
    $primaImmatricolazione = @DateTime::createFromFormat('d/m/Y', $_POST['inputPrimaImmatricolazione']);
	$primaImmatricolazione = @$primaImmatricolazione->getTimestamp();
    $t->primaImmatricolazione = $primaImmatricolazione;
    $t->cognome = maiuscolo( $_POST['inputCognome'] );
    $t->nome = maiuscolo( $_POST['inputNome'] );
    $t->indirizzo = $_POST['inputIndirizzo'];
    $t->anteriori = $_POST['inputAnt'];
    $t->posteriori = $_POST['inputPost'];
    $t->altAnt = $_POST['inputAltAnt'];
    $t->altPost = $_POST['inputAltPost'];
    $t->lunghezza = $_POST['inputLunghezza'];
    $t->larghezza = $_POST['inputLarghezza'];
    $t->tara = $_POST['inputTara'];
    $t->marca = $_POST['inputMarca'];
    $t->tipo = $_POST['inputTipo'];
    $t->massa = $_POST['inputMaxMassa'];
    $immatricolazione = @DateTime::createFromFormat('d/m/Y', $_POST['inputPrimaImmatricolazione']);
	$immatricolazione = @$immatricolazione->getTimestamp();
    $t->immatricolazione = $immatricolazione;
    $t->categoria = $_POST['inputCategoria'];
    $t->uso = $_POST['inputUso'];
    $t->carrozzeria = $_POST['inputCarozzeria'];
    $t->omologazione = $_POST['inputOmologazione'];
	$t->assi = $_POST['inputAssi'];
    $t->cilindrata = $_POST['inputCilindrata'];
    $t->potenza = $_POST['inputPotenza'];
    $t->alimentazione = $_POST['inputAlimentazione'];
    $t->posti = $_POST['inputPosti'];
    $t->regime = $_POST['inputRegime'];
    $t->tInserimento = time();
    $t->pInserimento = $me;
    $stato = $_POST['inputStato'];
    $t->stato = $stato;
    $intervallorevisione = $_POST['inputintervalloRevisione'];
    $t->intervalloRevisione = $intervallorevisione;

    if ( $stato == VEI_FUORIUSO ) {
        $t->tFuoriuso = time();
        $t->pFuoriuso = $me;
    }

    redirect('autoparco.veicoli&new');
}else{
    
    redirect('autoparco.veicoli&dup');
    
}

?>
