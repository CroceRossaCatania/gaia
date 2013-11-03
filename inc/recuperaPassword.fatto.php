<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$codice = $_GET['c'];

/* Cerca codice di validazione */
$validazione = Validazione::esiste($codice, false);
if(!$validazione){
	redirect('recuperaPassword&sca');
}

$p = Volontario::id($validazione->volontario());

/* Genera la password casuale */
$password = generaStringaCasuale(8, DIZIONARIO_ALFANUMERICO);

/* Imposta la password */
$p->cambiaPassword($password);

$e = new Email('generaPassword', 'Nuova password generata');
$e->a = $p;
$e->_NOME = $p->nome;
$e->_PASSWORD = $password;
$e->invia();

redirect('validazione.ok&pass');