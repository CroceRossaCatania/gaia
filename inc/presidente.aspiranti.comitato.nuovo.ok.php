<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAPP([APP_SOCI,APP_PRESIDENTE]);

$v = $_GET['id'];
$c = $_POST['inputComitato'];
$t = DT::createFromFormat('d/m/Y', $_POST['dataingresso']);

$a = new Appartenenza();
$a->volontario  = $v;
$a->comitato    = $c;
$a->inizio      = $t->getTimestamp();
$a->fine        = PROSSIMA_SCADENZA;
$a->timestamp = time();
$a->stato     = MEMBRO_VOLONTARIO;
$a->conferma  = $me;
$v = Volontario::id($v);
$v->stato    = VOLONTARIO;

/*Generazione password*/
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
$v->cambiaPassword($password);
$m = new Email('registrazioneFormatpass', 'Registrato su Gaia');
$m->a = $v;
$m->_NOME       = $v->nome;
$m->_PASSWORD   = $password;
$m->invia();

redirect('presidente.aspiranti&nasp');