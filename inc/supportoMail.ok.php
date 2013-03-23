<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$mail= 'informatica@cricatania.it';
$oggetto= $_POST['inputOggetto'];
$testo = $_POST['inputTesto'];
$mittente = $me->email;
$nome=$me->nome;
$cognome=$me->cognome;
$header = "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html; charset=utf-8\r\n";
$header .= 'From: "'.$nome.' '.$cognome.'" <'.$mittente.'> \r\n';
mail($mail, $oggetto, $testo, $header); 
redirect('me&ok');
?>