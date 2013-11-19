<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$coresidenza= normalizzaNome($_POST['inputComuneResidenza']);
$caresidenza= normalizzaNome($_POST['inputCAPResidenza']);
$prresidenza= maiuscolo($_POST['inputProvinciaResidenza']);
$indirizzo  = normalizzaNome($_POST['inputIndirizzo']);
$civico     = maiuscolo($_POST['inputCivico']);

$me->comuneResidenza     = $coresidenza;
$me->CAPResidenza        = $caresidenza;
$me->provinciaResidenza  = $prresidenza;
$me->indirizzo 		= $indirizzo;
$me->civico   		= $civico;

redirect('utente.anagrafica&ok');