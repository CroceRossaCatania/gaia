<?php
/*
* ©2013 Croce Rossa Italiana
*/
 
paginaPrivata();
 
$email = minuscolo($_POST['inputEmail']);
$emailServizio = minuscolo($_POST['inputemailServizio']);
 
if ( $email !== $me->email && Utente::by('email', $email) ) {
	redirect('utente.email&ep');
}

$codice = Validazione::generaValidazione($me , VAL_MAIL, $me->email);
if($codice==false){
	redirect('utente.email&gia');
}
$me->email = $email;

$e = new Email('validazioneMail', 'Richiesta di sostituizione email');
$e->a = $me;
$e->_NOME = $me->nome;
$e->_DATA = date('d-m-Y H:i');
$e->_CODICE = $codice;
$e->invia();

if($emailServizio){

$codice = Validazione::generaValidazione($me , VAL_MAIL, $me->emailServizio);
if($codice==false){
	redirect('utente.email&gia');
}
$me->emailServizio = $emailServizio;

$e = new Email('validazioneMail', 'Richiesta di sostituizione email');
$e->a = $me;
$e->_NOME = $me->nome;
$e->_DATA = date('d-m-Y H:i');
$e->_CODICE = $codice;
$e->invia();

} 

redirect('utente.email&link');