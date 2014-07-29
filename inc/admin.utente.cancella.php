<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'presidente.utenti&err');
$t = $_GET['id'];
$t = Utente::id($t);

$t->cancellaUtente();

redirect('presidente.utenti&ok');