<?php

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(array('c'), 'recuperaPassword&err');

$codice = $_GET['c'];

/* Cerca codice di validazione */
$validazione = Validazione::cercaValidazione($codice);
if(!$validazione){
	redirect('recuperaPassword&sca');
}

$p = $validazione->utente();

/* Genera la password casuale */
$password = generaStringaCasuale(8, DIZIONARIO_ALFANUMERICO);

/* Imposta la password */
$p->cambiaPassword($password);

$validazione->stato = VAL_CHIUSA;

$e = new Email('generaPassword', 'Nuova password generata');
$e->a = $p;
$e->_NOME = $p->nome;
$e->_PASSWORD = $password;
$e->invia();

redirect('validazione.ok&pass');