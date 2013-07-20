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

function paginaApp($app) {
    global $sessione;
    paginaPrivata();
    if ( $sessione->utente()->admin ) {
        return true;
    }
    if (!is_array($app)) {
        $app = [$app];
    }
    foreach ( $app as $k ) {
        if ( $sessione->utente()->delegazioni($k) ) {
            return true;
        }
    }
    redirect('errore.permessi');
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
        redirect('errore.permessi');
    }
}

function richiediComitato() {
    paginaPrivata();
    global $sessione;
    if ( !$sessione->utente()->comitati() ) {
        redirect('errore.comitato');
    }
}

function paginaAttivita( $attivita = null ) {
    global $sessione;
    richiediComitato();
    if (
         ( 
            ( $attivita instanceof Attivita )
            and
            !$attivita->modificabileDa($sessione->utente())
         )
            or
         !(
                (bool) $sessione->utente()->admin
            or  (bool) $sessione->utente()->presiede()
            or  (bool) $sessione->utente()->delegazioni(APP_OBIETTIVO)
            or  (bool) $sessione->utente()->areeDiResponsabilita()
            or  (bool) $sessione->utente()->attivitaReferenziate()
        )
    ) {
        redirect('errore.permessi');
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
    if ( $comitato && !in_array($comitato, $sessione->utente()->comitatiDiCompetenza() ) ) {
        redirect('utente.me&ErroreSicurezza');
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