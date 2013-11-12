<?php

/*
 * ©2013 Croce Rossa Italiana
 */	

$codiceFiscale = $_POST['inputCodiceFiscale'];
$codiceFiscale = maiuscolo($codiceFiscale);
$email = $_POST['inputEmail'];

$p = Utente::by('codiceFiscale', $codiceFiscale);
if (!$p) {
	redirect('recuperaPassword&cf');
} elseif($p->email != $email) {
	redirect('recuperaPassword&email');
}

/* Genera codice di validazione */
$codice = Validazione::generaValidazione($p, VAL_PASS);
if(!$codice){
	redirect('recuperaPassword&gia');
}

$e = new Email('recuperaPassword', 'Richiesta reimpostazione password');
$e->a = $p;
$e->_NOME = $p->nome;
$e->_DATA = date('d-m-Y H:i');
$e->_CODICE = $codice;
$e->invia();

?>
