<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$codice = $_GET['c'];

/* Cerca codice di validazione */
$validazione = Validazione::cercaValidazione($codice , VAL_MAIL);
if($validazione==false){
	redirect('&sca');
}

$validazione->stato = VAL_CHIUSO;

$e = new Email('convalidaEmail', 'Email sostituita');
$e->a = $p;
$e->_NOME = $p->nome;
$e->invia();

redirect('validazione.ok&mail');