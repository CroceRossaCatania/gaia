<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$codice = $_GET['c'];

/* Cerca codice di validazione */
$validazione = Validazione::cercaValidazione($codice);
if($validazione == false){
	redirect('validaEmail.ok&sca');
}

$stato = $validazione->stato;
$volontario = $validazione->utente();

if($validazione->stato==VAL_MAIL){
	$volontario->email = $validazione->note;
}elseif($validazione->stato==VAL_MAILS){
	$volontario->emailServizio = $validazione->note;
}

$e = new Email('validazioneMailok', 'Richiesta di sostituizione email');
$e->a       = $volontario;
$e->_NOME   = $volontario->nome;
$e->invia();

$validazione->stato = VAL_CHIUSA;

redirect('validaEmail');