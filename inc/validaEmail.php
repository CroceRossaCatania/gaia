<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$codice = $_GET['c'];

/* Cerca codice di validazione */
$validazione = Validazione::esiste($codice, false);
if($validazione == false){
	redirect('&sca');
}

$validazione->stato = VAL_CHIUSO;


/*
 * Inserire qui il secondi step di validazione!
 * Attenzione modificare l'email solamente quando il secondo step è ok
 * Serve un nuovo stato nelle validazioni
 */
$e = new Email('convalidaEmail', 'Email sostituita');
$e->a = $p;
$e->_NOME = $p->nome;
$e->invia();

redirect('validazione.ok&mail');