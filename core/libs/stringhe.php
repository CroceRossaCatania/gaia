<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/**
 * Ritorna una stringa normalizzata come nome (maiuscole e niente spazi di troppo)
 * @param string Una stringa
 * @return string La stringa normalizzata.
 */
function normalizzaNome( $stringa ) {
    $stringa = trim($stringa);
    $stringa = strtolower($stringa);
    $stringa = str_replace("'","' ",$stringa);
    $stringa = ucwords($stringa);
    $stringa = str_replace("' ","'",$stringa); 
    return $stringa;
}

/**
 * Ritorna una stringa normalizzata come titolo 
 * @param string Una stringa
 * @return string La stringa normalizzata
 */
function normalizzaTitolo( $stringa ) {
    $stringa = trim($stringa);
    $stringa = ucfirst($stringa);
    return $stringa;
}

/**
 * Ritorna una stringa in maiuscolo
 * @param string Una stringa
 * @return string La stringa maiuscola
 */
function maiuscolo( $stringa ) {
    $stringa = trim($stringa);
    $stringa = strtoupper($stringa);
    return $stringa;
}

/**
 * Ritorna una stringa in minuscolo
 * @param string Una stringa
 * @return string La stringa minuscola
 */
function minuscolo( $stringa ) {
    $stringa = trim($stringa);
    $stringa = strtolower($stringa);
    return $stringa;
}

/**
 * Genera una stringa casuale 
 * @param int $caratteri Numero di caratteri
 * @param int $dizionario Costante del dizionario da utilizzare
 * @param callable $controllo_esistenza nome di una funzione booleana che prende in input la stringa e ritorna true nel caso di esistenza (e genera un'altra stringa)
 * @return string La stringa generata
*/
function generaStringaCasuale(  $caratteri = 10, 
                                $dizionarioTipo = DIZIONARIO_ALFANUMERICO, 
                                $controllo_esistenza = null) {
    global $conf;

    // caratteri possibili
    $dizionario = $conf['dizionario'][$dizionarioTipo];

    //massima lunghezza caratteri
    $maxlength = strlen($dizionario);

    if (is_callable($controllo_esistenza)) {
        do {
            $codice = "";
            $i = 0; 
            while ($i < $caratteri) { 
                // prende un carattere casuale per creare il codice e lo accoda
                $char = substr($dizionario, mt_rand(0, $maxlength-1), 1);
                $codice .= $char;
                $i++;
            }
        /* controllo: $controllo_esistenza[0]::$controllo_esistenza[1]($codice)
         * se TRUE allora rigenera
         */
        } while (call_user_func($controllo_esistenza, $codice));
        return $codice;


    }

    $codice = "";
    $i = 0; 
    // aggiunge carattere casuale finchè non raggiunge lunghezza corretta
    while ($i < $caratteri) { 
        $char = substr($dizionario, mt_rand(0, $maxlength-1), 1);
        if (!strstr($codice, $char)) { 
            $codice .= $char;
            $i++;
        }
    }

    return $codice;
}

/**
 * Formatta un numero come monetario (italiano)
 *
 * es. 14.4 -> "14,40"
 * @param float $cifra  Il numero
 * @return string       Il numero in formato monetario
 */
function soldi($cifra) {
    return number_format($cifra, 2, ',', '.');
}

/**
 * Formata una stringa come nome file
 */
function nomefile($stringa) {
    $stringa = trim($stringa);
    $stringa = str_replace("..", ".", $stringa);
    $stringa = str_replace(":", "-", $stringa);
    $stringa = str_replace("~", "-", $stringa);
    $stringa = str_replace('"', '\"', $stringa);
    return $stringa;
}