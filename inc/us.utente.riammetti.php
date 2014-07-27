<?php

/*
 * ©2014 Croce Rossa Italiana
 */	

paginaApp([APP_SOCI , APP_PRESIDENTE]);
controllaParametri(array('id'), 'presidente.utenti.dimessi&errGen');
$u = Utente::id($_GET['id']);

if(!$u->riammissibile() || !$u->modificabileDa($me)){
	redirect('presidente.utenti.dimessi&err');
}

$c = $u->ultimaAppartenenza(MEMBRO_DIMESSO)->comitato();

$u->stato = VOLONTARIO;

$a = new Appartenenza();
$a->volontario = $u;
$a->comitato = $c;
$a->inizio = time();
$a->fine = PROSSIMA_SCADENZA;
$a->stato = MEMBRO_VOLONTARIO;
$a->timestamp = time();
$a->conferma = $me;

//bisogna mandare email e fare in modo che non stia più tra i dimessi, 
//inserire pagamento quota reintegro e cazzi e mazzi