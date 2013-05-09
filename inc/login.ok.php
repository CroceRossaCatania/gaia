<?php

/*
 * ©2012 Croce Rossa Italiana
 */

$email      = minuscolo($_POST['inputEmail']);
$password   = $_POST['inputPassword'];

if ( $u = Utente::by('email', $email) ) {
    if ( $u->login($password) ) {
        $sessione->utente = $u->id;
        if ( $_POST['torna'] ) {
            redirect($_POST['torna']);
        } else {
            redirect('utente.me');
        }
    } else {
        $sessione->torna = $_POST['torna'];
        redirect('login&password');
    }
} else {
    $sessione->torna = $_POST['torna'];
    redirect('login&email');
}