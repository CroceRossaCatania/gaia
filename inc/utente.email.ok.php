<?php
/*
* ©2013 Croce Rossa Italiana
*/
 
paginaPrivata();
$newemail = $sessione->email;
$newmailservizio = $sessione->emailServizio;
$password = $_POST['inputPassword'];

if(!$me->login($password)){
    redirect('utente.email&pass');
}

if ( $newemail != $me->email && Utente::by('email', $newemail) ) {
    redirect('utente.email&ep');
}else{
    /* Genera codice di validazione */
    $codice = Validazione::generaValidazione($me, VAL_MAIL, $newemail);
    if(!$codice){
        redirect('utente.email&gia');
    }

    /* Stratagemma per mandare la mail al nuovo indirizzo e validarlo */
    $email = $me->email;
    $me->email = $newemail;

    $e = new Email('validazioneMail', 'Richiesta sostituzione indirizzo email');
    $e->a       = $me;
    $e->_NOME   = $p->nome;
    $e->_DATA   = date('d-m-Y H:i');
    $e->_TIPO   = 'personale';
    $e->_NUOVA  = $newemail;
    $e->_CODICE = $codice;
    $e->invia();

    $me->email = $email;
    redirect('utente.email&ok');
}

if($newmailservizio != $me->newmailservizio && Utente::by('email', $newmailservizio)){
    redirect('utente.email&ep');
}else{
    /* Genera codice di validazione */
    $codice = Validazione::generaValidazione($me, VAL_MAILS, $newemailservizio);
    if(!$codice){
        redirect('utente.email&gia');
    }

    /* Stratagemma per mandare la mail al nuovo indirizzo e validarlo */
    $email = $me->email;
    $me->email = $newemailservizio;

    $e = new Email('validazioneMail', 'Richiesta sostituzione indirizzo email');
    $e->a       = $me;
    $e->_NOME   = $p->nome;
    $e->_DATA   = date('d-m-Y H:i');
    $e->_TIPO   = 'di servizio';
    $e->_NUOVA  = $newemailservizio;
    $e->_CODICE = $codice;
    $e->invia();

    $me->email = $email;
    redirect('utente.email&ok');
}