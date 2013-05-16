<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/*
 * Rende la corrente pagina privata (login necessario)
 */
function paginaPrivata() {
    global $sessione, $_GET;
    if ( !$sessione->utente() ) {
        $sessione->torna = base64_encode(serialize($_GET));
        redirect('login');
    }
}

function paginaPubblica() {
    global $sessione;
    if ( $sessione->utente ) {
        redirect('utente.me');
    }
}

function paginaAdmin() {
    paginaPrivata();
    global $sessione;
    if ( !$sessione->utente()->admin ) {
        redirect('utente.me');
    }
}

function richiediComitato() {
    paginaPrivata();
    global $sessione;
    if ( !$sessione->utente()->comitati() ) {
        redirect('errore.comitato');
    }
}

function paginaAttivita() {
    richiediComitato();
    global $sessione;
    if (!(
                (bool) $sessione->utente()->admin
            or  (bool) $sessione->utente()->presiede()
            or  (bool) $sessione->utente()->delegazioni(APP_OBIETTIVO)
            or  (bool) $sessione->utente()->areeDiResponsabilita()
    )) {
        redirect('utente.me');
    }
}

function paginaModale() {
    include('./inc/part/pagina.attendere.php');
}

function paginaPresidenziale( $comitato = null ) {
    global $sessione;
        paginaPrivata();
    if ( !$sessione->utente()->presiede() && !$sessione->utente()->admin ) {
        redirect('utente.me');
    }
    if ( $comitato && !$sessione->utente()->admin ) {
        //var_dump($comitato->volontariPresidenti());
        //var_dump($sessione->utente());
        if ( !in_array($sessione->utente(), $comitato->volontariPresidenti() ) ) {
           //redirect('utente.me&erroreSicurezza');
        }
    }
}

function menuVolontario() {
    include('./inc/part/utente.menu.php');
}

function caricaSelettore() {
    global $_carica_selettore;
    $_carica_selettore = true;
}

/*
 * Redirige ad una pagina
 * @param $pagina la pagina richiesta
 */
function redirect($pagina) {
    header('Location: ?p=' . $pagina);
    exit(0);
}

/*
 * Effettua un redirect ad index.php?{$queryString}
 */
function lowRedirect($b64) {
    $b64 = base64_decode($b64);
    $b64 = unserialize($b64);
    $b64 = http_build_query($b64);
    header("Location: index.php?{$b64}");
    exit(0);
}

function paginaAnonimo() {
    global $me;
    if (!$me) {
        $me = new Anonimo();
    }
}

function paginaAnonimoComitato() {
    global $me;
    if ($me) {
        richiediComitato();
    }   else {
        paginaAnonimo();
    } 
}

function impostaTitoloDescrizione( $contenuto ) {
    global $_titolo, $_descrizione;
    $contenuto = str_replace('{_titolo}', $_titolo, $contenuto);
    $contenuto = str_replace('{_descrizione}', $_descrizione, $contenuto);
    return $contenuto;
}