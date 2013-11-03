<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$codice = $_GET['c'];

/* Cerca codice di validazione */
$validazione = Validazione::esiste($codice, false);
if($validazione == false){
	redirect('validazione.ok&sca');
}

$volontario = $validazione->volontario();

if($validazione->stato==VAL_MAIL2){
	$volontario->email = $validazione->note;
}elseif($validazione->stato==VAL_MAILS2){
	$volontario->emailServizio = $validazione->note;
}

$e = new Email('validazioneMailok', 'Richiesta di sostituizione email');
$e->a       = $volontario;
$e->_NOME   = $volontario->nome;
$e->invia();

redirect('validazione.ok&mail');