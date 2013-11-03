<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$codice = $_GET['c'];

/* Cerca codice di validazione */
$validazione = Validazione::cercaValidazione($codice, VAL_EMAIL);
if($validazione == false){
	redirect('validazione.ok&sca');
}

$stato = $validazione->stato
$validazione->stato = VAL_CHIUSO;
$volontario = $validazione->volontario();

if($stato==VAL_MAIL){
	$codice = Validazione::generaValidazione($volontario , VAL_MAIL2, $validazione->note);
}else{
	$codice = Validazione::generaValidazione($volontario , VAL_MAILS2, $validazione->note);
}

if($codice == false){
    redirect('validazione.ok&gia');
}

$email = $volontario->email;

$e = new Email('validazioneMail2', 'Richiesta di sostituizione email');
$e->a       = $volontario;
$e->_NOME   = $volontario->nome;
$e->_CODICE = $codice;
$e->invia();

$volontario->email = $email;

redirect('validazione.ok&mail');