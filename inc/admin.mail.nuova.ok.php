<?php

/*
 * ©2013 Croce Rossa Italiana
 */
$parametri = array('inputTesto', 'inputOggetto');
controllaParametri($parametri);
$oggetto= $_POST['inputOggetto']; 
$testo = $_POST['inputTesto'];

if(isset($_GET['pres'])){

	foreach ( Comitato::elenco() as $c ) {
	$presidenti[] = $c->unPresidente();
	}

	$presidenti = array_unique($presidenti);
	$delegati = array_unique($delegati);
	$i =0;

	foreach($presidenti as $presidente){
	    $m = new Email('mailTestolibero', ''.$oggetto);
	    $m->a = $presidente;
	    $m->_TESTO = $testo;
	    $m->invia();    
	    $i++;
	}

	$a = new Annunci();
	$a->oggetto = $oggetto;
	$a->testo = $testo;
	$a->nPresidenti = $i;
	$a->timestamp = time();
	$a->autore = $me;

}else{	

	$delegati = Delegato::filtra([
    	['applicazione', APP_OBIETTIVO]
	]);

	$delegati = array_unique($delegati);

	foreach ( $delegati as $delegato ) {
	    
	    // Ignoro i delegati non più attuali
	    if ( !$delegato->attuale() ) { continue; }
	    
	    // Carico il volontario in memoria
	    $_v = $delegato->volontario();
	    $m = new Email('mailTestolibero', ''.$oggetto);
	    $m->a = $_v;
	    $m->_TESTO = $testo;
	    $m->invia();  
	}
}

redirect('utente.me&ok');

?>
