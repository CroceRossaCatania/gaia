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

redirect('utente.anagrafica&ok');
