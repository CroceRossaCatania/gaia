<?php
/*
* ©2013 Croce Rossa Italiana
*/
 
paginaPrivata();
$newemail = $sessione->email;
$newemailservizio = $sessione->emailServizio;
$password = $_POST['inputPassword'];

if(!$me->login($password)){
    redirect('utente.contatti&emailpass');
}

if($newemail && $newemail != $me->email) {
    if (Utente::by('email', $newemail) ) {
        redirect('utente.contatti&emailep');
    }else{
        /* Genera codice di validazione */
        $codice = Validazione::generaValidazione($me, VAL_MAIL, $newemail);
        if(!$codice){
            redirect('utente.contatti&emailgia');
        }

        /* Stratagemma per mandare la mail al nuovo indirizzo e validarlo */
        $email = $me->email;
        $me->email = $newemail;

        $e = new Email('validazioneMail', 'Richiesta sostituzione indirizzo email');
        $e->a       = $me;
        $e->_NOME   = $me->nome;
        $e->_DATA   = date('d-m-Y H:i');
        $e->_TIPO   = 'personale';
        $e->_NUOVA  = $newemail;
        $e->_CODICE = $codice;
        $e->invia();

        $me->email = $email;
        redirect('utente.contatti&emailok');
    }
}

if($me->stato == VOLONTARIO 
    && $newemailservizio 
    && $newemailservizio != $me->emailservizio) {
    
    if(Utente::by('email', $newemailservizio)){
        redirect('utente.contatti&emailep');
    }else{
        /* Genera codice di validazione */
        $codice = Validazione::generaValidazione($me, VAL_MAILS, $newemailservizio);
        if(!$codice){
            redirect('utente.contatti&emailgia');
        }

        /* Stratagemma per mandare la mail al nuovo indirizzo e validarlo */
        $email = $me->email;
        $me->email = $newemailservizio;

        $e = new Email('validazioneMail', 'Richiesta sostituzione indirizzo email');
        $e->a       = $me;
        $e->_NOME   = $me->nome;
        $e->_DATA   = date('d-m-Y H:i');
        $e->_TIPO   = 'di servizio';
        $e->_NUOVA  = $newemailservizio;
        $e->_CODICE = $codice;
        $e->invia();

        $me->email = $email;
        redirect('utente.contatti&emailok');
    }
}

redirect('utente.contatti&emailep');