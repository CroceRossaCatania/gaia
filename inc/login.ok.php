<?php

/*
 * ©2012 Croce Rossa Italiana
 */

if ( !captcha_controlla($_POST['sckey'], $_POST['scvalue']) ) {
    $sessione->torna = $_POST['torna'];
    redirect('login&captcha');
}

$parametri = ['inputEmail', 'inputPassword'];
controllaParametri($parametri, 'login');

$email      = minuscolo($_POST['inputEmail']);
$password   = $_POST['inputPassword'];

if ( $u = Utente::by('email', $email) ) {
    if ( $u->login($password) ) {
        $sessione->utente = $u->id;
        if ( $_POST['torna'] ) {
            lowRedirect($_POST['torna']);
            $sessione->app_id = null;
            $sessione->app_ip = null;
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