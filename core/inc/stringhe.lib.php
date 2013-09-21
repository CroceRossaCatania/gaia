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
