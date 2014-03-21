<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

$parametri = array('inputComuneResidenza', 'inputCAPResidenza', 'inputProvinciaResidenza', 'inputIndirizzo', 'inputCivico');
controllaParametri($parametri);

$coresidenza = normalizzaNome($_POST['inputComuneResidenza']);
$caresidenza = normalizzaNome($_POST['inputCAPResidenza']);
$prresidenza = maiuscolo($_POST['inputProvinciaResidenza']);
$indirizzo   = normalizzaNome($_POST['inputIndirizzo']);
$civico      = maiuscolo($_POST['inputCivico']);

$me->comuneResidenza     = $coresidenza;
$me->CAPResidenza        = $caresidenza;
$me->provinciaResidenza  = $prresidenza;
$me->indirizzo 			 = $indirizzo;
$me->civico   			 = $civico;

if ($me->stato == ASPIRANTE && $a = Aspirante::daVolontario($me)) {
	$a->localizzaStringa("{$me->indirizzo}, {$me->comuneResidenza}, {$me->CAPResidenza}");
	$a->raggio = $a->trovaRaggioMinimo();
}

redirect('utente.anagrafica&ok');