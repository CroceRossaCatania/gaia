<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Validazione extends Entita {

    protected static
        $_t  = 'validazioni',
        $_dt = null;

    public static function generaPassword() {
        $length = 8;

        // impostare password bianca
        $password = "";

        // caratteri possibili
        $possible = "123467890abcdefghijklmnopqrtsuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!?$%&";

        //massima lunghezza caratteri
        $maxlength = strlen($possible);
          
        // se troppo lunga taglia la password
        if ($length > $maxlength) {
              $length = $maxlength;
        }
            
        $i = 0; 
            
        // aggiunge carattere casuale finchè non raggiunge lunghezza corretta
        while ($i < $length) { 

            // prende un carattere casuale per creare la password
           $char = substr($possible, mt_rand(0, $maxlength-1), 1);

            // verifica se il carattere precedente è uguale al successivo
            if (!strstr($password, $char)) { 
                $password .= $char;
                $i++;
            }

        }
        return $password;
    }

    public static function generaValidazione($v, $stato, $note) {

        $validazione = Validazione::filtra([['volontario', $v],['stato', $stato]]);
        if($validazione){
            return false;
        }

        /*Inserire qui la genereazione della stringa casuale */
        $caratteri= 26;
        $dizionario = DIZIONARIO_ALFANUMERICO;
        $controllo_esistenza = null;
        $codice = generaStringaCasuale($caratteri,$dizionario,$controllo_esistenza);
        /**/

        $val = new Validazione();
        $val->codice = $codice;
        $val->stato = $stato;
        $val->volontario = $v;
        $val->timestamp = time();
        $val->note = $note;
        return $codice;
    }

    public static function cercaValidazione($codice , $stato) {

        $validazione = Validazione::filtra([['codice', $codice],['stato', $stato]]);
        if(!$validazione){
            return false;
        }
        return $validazione[0];
    }

    public function volontario() {
        return Volontario::id($this->volontario);
    }

}