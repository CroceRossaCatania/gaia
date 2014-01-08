<?php

/*
 * ©2013 Croce Rossa Italiana
 */	

paginaAdmin();

controllaParametri(['id'], 'presidente.utenti&err');

$p = Utente::id($_GET['id']);

/* Genera codice di validazione */
$codice = Validazione::generaValidazione($p, VAL_PASS);

$e = new Email('recuperaPasswordAdmin', 'Richiesta reimpostazione password');
$e->a = $p;
$e->_NOME = $p->nome;
$e->_ADMIN = $me->nomeCompleto();
$e->_DATA = date('d-m-Y H:i');
$e->_CODICE = $codice;
$e->invia();

redirect('presidente.utenti&reset');
?>
