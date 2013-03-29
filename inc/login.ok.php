<?php

/*
 * ©2012 Croce Rossa Italiana
 */

$email      = minuscolo($_POST['inputEmail']);
$password   = $_POST['inputPassword'];

if ( $u = Utente::by('email', $email) ) {
    if ( $u->login($password) ) {
        $sessione->utente = $u->id;
        redirect('utente.me');
    } else {
        redirect('login&password');
    }
} else {
    redirect('login&email');
}