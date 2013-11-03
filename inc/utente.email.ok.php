<?php
/*
* ©2013 Croce Rossa Italiana
*/
 
paginaPrivata();
 
$email = minuscolo($_POST['inputEmail']);
$emailServizio = minuscolo($_POST['inputemailServizio']);
 
if ( $email != $me->email && Utente::by('email', $email) ) {
    redirect('utente.email&ep');
} else {
    $codice = Validazione::generaValidazione($me , VAL_MAIL, $email);
    if($codice == false){
        redirect('utente.email&gia');
    }

    $e = new Email('validazioneMail', 'Richiesta di sostituizione email');
    $e->a       = $me;
    $e->_TIPO   = "personale";
    $e->_NOME   = $me->nome;
    $e->_NUOVA  = $email;
    $e->_DATA   = date('d-m-Y H:i');
    $e->_CODICE = $codice;
    $e->invia();

}

if($emailServizio != $me->emailServizio && Utente::by('email', $emailServizio)){
    redirect('utente.email&ep');
} else {
    $codice = Validazione::generaValidazione($me , VAL_MAIL, $emailServizio);
    if($codice == false){
        redirect('utente.email&gia');
    }

    $e = new Email('validazioneMail', 'Richiesta di sostituizione email');
    $e->a       = $me;
    $e->_TIPO   = "di servizio";
    $e->_NOME   = $me->nome;
    $e->_NUOVA  = $emailServizio;
    $e->_DATA   = date('d-m-Y H:i');
    $e->_CODICE = $codice;
    $e->invia();

}

redirect('utente.email&link');