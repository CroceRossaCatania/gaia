<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/**
 * Ritorna una stringa normalizzata come nome (maiuscole e niente spazi di troppo)
 * @param string Una stringa
 * @return string La stringa normalizzata
 */
function normalizzaNome( $stringa ) {
    $stringa = trim($stringa);
    $stringa = strtolower($stringa);
    $stringa = ucwords($stringa);
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
                                $dizionario = DIZIONARIO_ALFANUMERICO, 
                                $controllo_esistenza = null) {
    // caratteri possibili
    $dizionario = $conf[$dizionario];

    //massima lunghezza caratteri
    $maxlength = strlen($dizionario);

    if (is_callable($controllo_esistenza)) {
        do {
            $codice = "";
            $i = 0; 
            while ($i < $length) { 

                // prende un carattere casuale per creare il codice
                $char = substr($dizionario, mt_rand(0, $maxlength-1), 1);

                // verifica se il carattere precedente è uguale al successivo
                if (!strstr($codice, $char)) { 
                    $codice .= $char;
                    $i++;
                }
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
    while ($i < $length) { 
        $char = substr($dizionario, mt_rand(0, $maxlength-1), 1);
        if (!strstr($codice, $char)) { 
            $codice .= $char;
            $i++;
        }
    }

    return $codice;
}
