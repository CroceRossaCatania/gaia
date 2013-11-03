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
 * Genera una stringa casuale 
 * @param int $caratteri Numero di caratteri
 * @param int $dizionario Costante del dizionario da utilizzare
 * @param callable $controllo_esistenza nome di una funzione booleana che prende in input la stringa e ritorna true nel caso di esistenza (e genera un'altra stringa)
 * @return string La stringa generata
*/
function generaStringaCasuale(  $caratteri = 10, 
                                $dizionario = DIZIONARIO_ALFANUMERICO, 
                                $controllo_esistenza = null) {
    // impostare password bianca
    

    // caratteri possibili
    $dizionario = $conf[$dizionario];

    //massima lunghezza caratteri
    $maxlength = strlen($dizionario);
      
    

    if (is_callable($controllo_esistenza)) {
        do {
            $password = "";
            $i = 0; 
            // aggiunge carattere casuale finchè non raggiunge lunghezza corretta
            while ($i < $length) { 

                // prende un carattere casuale per creare la password
                $char = substr($dizionario, mt_rand(0, $maxlength-1), 1);

                // verifica se il carattere precedente è uguale al successivo
                if (!strstr($password, $char)) { 
                    $password .= $char;
                    $i++;
                }
            }
        /* controllo: $controllo_esistenza[0]::$controllo_esistenza[1]($password)
         * se TRUE allora rigenera
         */
        } while (call_user_func(array_merge($controllo_esistenza, $password)));
        return $password;


    }

    $password = "";
    $i = 0; 
    // aggiunge carattere casuale finchè non raggiunge lunghezza corretta
    while ($i < $length) { 

        $char = substr($dizionario, mt_rand(0, $maxlength-1), 1);

        if (!strstr($password, $char)) { 
            $password .= $char;
            $i++;
        }
    }

    return $password;
}
