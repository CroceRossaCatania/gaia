<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/*
 * Rende la corrente pagina privata (login necessario)
 * e controlla il consenso alle condizioni d'uso
 * @param $consenso = false solo per la pagina di consenso
 */
function paginaPrivata($consenso = true) {
    global $sessione, $_GET;
    if ( !$sessione->utente() ) {
        $sessione->torna = base64_encode(serialize($_GET));
        redirect('login');
    }
    if ($consenso && !$sessione->utente()->consenso()) {
        redirect('utente.me');
    }
    controllaBrowser();
}

/**
 * Controlla che il browser utilizzato sia non sia una vecchia versione di IE
 * (ho escuso quelle precedenti alla 3 per evitare che la regex si mangi il 10)
 */
function controllaBrowser() {
    if(preg_match('/(?i)msie [3-8]/',$_SERVER['HTTP_USER_AGENT'])) {
        redirect('public.browser');
    }
}

function paginaApp($app, $comitati = []) {
    global $sessione;
    paginaPrivata();
    if ( $sessione->utente()->admin() ) {
        return true;
    }
    if (!is_array($app)) {
        $app = [$app];
    }
    if (!is_array($comitati)) {
        $comitati = [$comitati];
    }
    foreach ( $app as $k ) {
        
        // Per ogni delegazione dell'utente (vecchia versione)
        //if ( $d = $sessione->utente()->delegazioni($k) ) {
        
        // Variazione per issue #867
        $d = $sessione->utente()->delegazioneAttuale();
        if ( $d && $d->applicazione == $k ) {
            // Se è attivo il filtraggio per comitato
            if ( $comitati ) {
                // Ritorna vero solo se il comitato è contenuto
                foreach ( $comitati as $comitato ) {
                    if (!$comitato instanceof GeoPolitica) { continue; }
                        if ( $d->comitato()->contiene($comitato) ) { return true; } 
                }
            } else {
                
                // Filtraggio non attivo, ma da qualche parte ho la delega
                return true;
                
            }
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
    if ( !$sessione->utente()->admin || $sessione->adminMode == '') {
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
                (bool) $sessione->utente()->admin()
            or  (bool) $sessione->utente()->presiede()
            or  (bool) $sessione->utente()->delegazioni(APP_OBIETTIVO)
            or  (bool) $sessione->utente()->areeDiResponsabilita()
            or  (bool) $sessione->utente()->attivitaReferenziate()
        )
    ) {
        redirect('errore.permessi');
    }
}

function paginaCorsoBase( $corsoBase = null ) {
    global $sessione;
    richiediComitato();
    if (
         ( 
            ( $corsoBase instanceof CorsoBase )
            and
            !$corsoBase->modificabileDa($sessione->utente())
         )
            or
         !(
                (bool) $sessione->utente()->admin()
            or  (bool) $sessione->utente()->presiede()
            or  (bool) $sessione->utente()->delegazioni(APP_FORMAZIONE)
            or  (bool) $sessione->utente()->corsiBaseDiGestione()
        )
    ) {
        redirect('errore.permessi');
    }
}

function paginaModale() {
    include('./inc/part/pagina.attendere.php');
}

function paginaPresidenziale( $comitato = null, $attivita = null) {
    global $sessione;
        paginaPrivata();
    if ( !$sessione->utente()->presiede() && !$sessione->utente()->admin() ) {
        redirect('utente.me');
    }
    if ( $comitato && !in_array($comitato, $sessione->utente()->comitatiDiCompetenza() ) ) {
        redirect('errore.permessi');
    }

    if ( $attivita && !in_array($attivita, $sessione->utente()->attivitaDiGestione())) {
        redirect('errore.permessi');   
    }
}

function menuVolontario() {
    global $me;
    if ( $me && $me->stato == ASPIRANTE ) {
        menuAspirante();
        return;
    }elseif($me && ($me->ordinario() || $me->ordinariodimesso())){
        menuOrdinario();
        return;
    }
    $d = Delegato::filtra([
        ['volontario', $me->id]
        ]);
    if ($d) {
        scegliRuolo();
    }
    include('./inc/part/utente.menu.php');
}

function menuAspirante() {
    include('./inc/part/aspirante.menu.php');
}

function menuOrdinario() {
    include('./inc/part/ordinario.menu.php');
}

function scegliRuolo() {
    include('./inc/part/utente.selettore.ruolo.php');
}

$_lista_attiva = $_link_excel = $_link_email = null;
function menuElenchiVolontari($a = "Volontari attivi", $b = '#', $c = '#') {
    global $_lista_attiva, $_link_excel, $_link_email;
    $_lista_attiva = $a;
    $_link_excel   = $b;
    $_link_email   = $c;
    include './inc/part/presidente.utenti.liste.php';
}

function caricaSelettore() {
    global $_carica_selettore;
    $_carica_selettore = true;
}

function caricaSelettoreComitato() {
    global $_carica_selettore_comitato;
    $_carica_selettore_comitato = true;
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

function controllaParametri($parametri = [], $redirect = 'utente.me&err') {
    foreach ($parametri as $p) {
        if (empty($_REQUEST[$p])) { redirect($redirect); }
    }
}

function proteggiClasse(Entita $e, Utente $utente) {
    if($e->modificabileDa($utente)) {
        return true;
    } 
    redirect('errore.permessi');
}

