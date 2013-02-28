<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

$email      = minuscolo($_POST['inputEmail']);

if ( Utente::by('email', $email) ) {
    redirect('email&e');
}

$me->email               = $email;

redirect('email&ok');