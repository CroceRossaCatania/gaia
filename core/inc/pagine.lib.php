<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/*
 * Rende la corrente pagina privata (login necessario)
 */
function paginaPrivata() {
    global $sessione;
    if ( $sessione->utente == null ) {
        redirect('login');
    }
}

function paginaPubblica() {
    global $sessione;
    if ( $sessione->utente ) {
        redirect('me');
    }
}

function paginaAdmin() {
    paginaPrivata();
    global $sessione;
    if ( !$sessione->utente()->admin ) {
        redirect('me');
    }
}

function paginaPresidenziale() {
    paginaPrivata();
    global $sessione;
    if ( !$sessione->utente()->presiede() && !$sessione->utente()->admin ) {
        redirect('me');
    }
}

function menuVolontario() {
    include('./inc/menuVolontario.php');
}

/*
 * Redirige ad una pagina
 * @param $pagina la pagina richiesta
 */
function redirect($pagina) {
    header('Location: ?p=' . $pagina);
    exit(0);
}