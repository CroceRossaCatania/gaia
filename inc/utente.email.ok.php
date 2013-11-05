<?php
/*
* ©2013 Croce Rossa Italiana
*/
 
paginaPrivata();
 
$email = $sessione->email;
$emailServizio = $sessione->emailServizio;
$password = $_POST['inputPassword'];

if(!$me->login($password)){
    redirect('utente.email&pass');
}

if ( $email != $me->email && Utente::by('email', $email) ) {
    redirect('utente.email&ep');
}else{
    $me->email = $email;
    $e = new Email('cambioMail', 'Richiesta di sostituizione email');
    $e->a       = $me;
    $e->_TIPO   = "personale";
    $e->_NOME   = $me->nome;
    $e->_NUOVA  = $email;
    $e->_DATA   = date('d-m-Y H:i');
    $e->invia();
    redirect('utente.email&ok');
}

if($emailServizio != $me->emailServizio && Utente::by('email', $emailServizio)){
    redirect('utente.email&ep');
}else{
    $me->emailServizio = $emailServizio;
    $e = new Email('cambioMail', 'Richiesta di sostituizione email');
    $e->a       = $me;
    $e->_TIPO   = "di servizio";
    $e->_NOME   = $me->nome;
    $e->_NUOVA  = $emailServizio;
    $e->_DATA   = date('d-m-Y H:i');
    $e->invia();
    redirect('utente.email&ok');
}