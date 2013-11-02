<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$codice = $_GET['c'];

/* Cerca codice di validazione */
$validazione = Validazione::cercaValidazione($codice,VAL_PASS);
if($validazione==false){
	redirect('recuperaPassword&sca');
}

$p = Volontario::id($validazione->volontario());

/* Genera la password casuale */
$password = Validazione::generaPassword();

/* Imposta la password */
$p->cambiaPassword($password);

$e = new Email('generaPassword', 'Nuova password generata');
$e->a = $p;
$e->_NOME = $p->nome;
$e->_PASSWORD = $password;
$e->invia();

redirect('login');