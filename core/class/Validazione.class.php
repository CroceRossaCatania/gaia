<?php

/*
 * ©2013 Croce Rossa Italiana
 */

class Validazione extends Entita {

    protected static
        $_t  = 'validazioni',
        $_dt = null;

    public static function generaPassword() {
        $length = 6;

        // impostare password bianca
        $password = "";

        // caratteri possibili
        $possible = "12346789abcdefghijklmnopqrtsuvwxyzABCDEFGHIJKLMNoPQRSTUVWXYZ";

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

        $length = 14;

        // impostare codice bianca
        $codice = "";

        // caratteri possibili
        $possible = "12346789abcdefghijklmnopqrtsuvwxyzABCDEFGHIJKLMNoPQRSTUVWXYZ";

         //massima lunghezza caratteri
         $maxlength = strlen($possible);
          
         // se troppo lunga taglia la codice
        if ($length > $maxlength) {
              $length = $maxlength;
        }
            
        $i = 0; 
            
         // aggiunge carattere casuale finchè non raggiunge lunghezza corretta
         while ($i < $length) { 

            // prende un carattere casuale per creare la codice
           $char = substr($possible, mt_rand(0, $maxlength-1), 1);

            // verifica se il carattere precedente è uguale al successivo
           if (!strstr($codice, $char)) { 
                $codice .= $char;
                $i++;
           }

        }
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
        return Validazione::id($validazione[0]);
    }

    public function volontario() {
        return Volontario::id($this->volontario);
    }

}