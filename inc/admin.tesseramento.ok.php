<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(['tesseramenti'],'admin.tesseramento&err');

paginaAdmin();

foreach ( $_POST['tesseramenti'] as $tesseramento ) {
	$t = Tesseramento::id($tesseramento);
	$t->stato 	= $_POST["{$tesseramento}_stato"];
	if ($t->aperto()) {
	    $inizio		= DT::createFromFormat('d/m/Y', $_POST["{$tesseramento}_inizio"]);
    	$t->inizio 	= $inizio->getTimestamp();
    	$fine       = DT::createFromFormat('d/m/Y', $_POST["{$tesseramento}_fine"]);
    	$t->fine 	= $fine->getTimestamp();
    	$importoA = (float) $_POST["{$tesseramento}_attivo"];
		$t->attivo = round($importoA, 2);
		$importoO = (float) $_POST["{$tesseramento}_ordinario"];
		$t->ordinario = round($importoO, 2);
		$importoB = (float) $_POST["{$tesseramento}_benemerito"];
		$t->benemerito = round($importoB, 2);
    	
    } 
}

redirect('admin.tesseramento&ok');

?>
