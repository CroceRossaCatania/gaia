<?php

/*
 * ©2012 Croce Rossa Italiana
 */
$codiceFiscale = $_POST['inputCodiceFiscale'];
$codiceFiscale = maiuscolo($codiceFiscale);

$p = Utente::by('codiceFiscale', $codiceFiscale);
if (!$p) {
	redirect('resetPassword&e');
} 

$length = 6;

// impostare password bianca
$password = "";

// caratteri possibili
$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

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

$p->cambiaPassword($password);

$e = new Email('recuperaPassword', 'Richiesta reimpostazione password');
$e->a = $p;
$e->_NOME = $p->nome;
$e->_DATA = date('d-m-Y H:i');
$e->_NUOVA = $password;
$e->invia();

redirect('recuperaPassword.fatto');
