<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/*
 * Ritorna una stringa normalizzata come nome (maiuscole e niente spazi di troppo)
 * @return string La stringa normalizzata
 */
function normalizzaNome( $stringa ) {
    $stringa = trim($stringa);
    $stringa = strtolower($stringa);
    $stringa = ucwords($stringa);
    return $stringa;
}

/*
 * Ritorna una stringa normalizzata come titolo 
 * @return string La stringa normalizzata
 */
function normalizzaTitolo( $stringa ) {
    $stringa = trim($stringa);
    $stringa = ucfirst($stringa);
    return $stringa;
}

/*
 * Ritorna una stringa in maiuscolo
 * @return string La stringa maiuscola
 */
function maiuscolo( $stringa ) {
    $stringa = trim($stringa);
    $stringa = strtoupper($stringa);
    return $stringa;
}

/*
 * Ritorna una stringa in minuscolo
 * @return string La stringa minuscola
 */
function minuscolo( $stringa ) {
    $stringa = trim($stringa);
    $stringa = strtolower($stringa);
    return $stringa;
}


/**
 * Converte notazione pagina -> file, es.
 * (IGNORA GLI ALTRI PARAMETRI GET)
 * /utente/me               =>  utente.me
 * /attivita/scheda?id=4    =>  attivita.scheda
 */
function convertiNotazioneURLFile ( $p1 ) {
    $p1 = str_replace(':', '%3A', $p1);
    $p1 = parse_url($p1, PHP_URL_PATH);
    $p1 = str_replace('/', '.', $p1);
    $p1 = trim($p1, '.');
    return $p1;
}

/**
 * Converte notazione file -> pagina, es.
 * utente.me                => utente/me
 * attivita.scheda&id=4     => utente.me?id=4
 */
function convertiNotazioneFileURL ( $p1 ) {
    $p1 = explode('&', $p1);
    $pagina = "/{$p1[0]}";
    $pagina = str_replace('.', '/', $pagina);
    $parametri = array_slice($p1, 1);
    if ( $parametri ) {
        $stringa = "{$pagina}?" . implode('&', $parametri);
    } else {
        $stringa = $pagina;
    }
    return $stringa;
}

/**
 * Converte notazione file -> pagina, es.
 * ?p=utente.me               => utente/me
 * /?p=attivita.scheda&id=4   => utente.me?id=4
 */
function convertiNotazioneVecchia ( $p ) {
    $p = trim($p, '/');
    $p = explode('?p=', $p);
    if ( count($p) == 1 ) {
        $x = $p[0];
    }
    $x = $p[1];
    return convertiNotazioneFileURL($x);
}
