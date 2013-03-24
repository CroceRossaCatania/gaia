<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

$email      = minuscolo($_POST['inputEmail']);

if ( Utente::by('email', $email) ) {
    redirect('utente.email&e');
}

$me->email               = $email;

redirect('utente.email&ok');