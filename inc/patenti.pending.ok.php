<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE, APP_PATENTE]);

controllaParametri(array('id'), 'patenti.pending&err');

$id     = $_GET['id'];
$t      = Patente::id($id);
$v      = $t->volontario();
if (!$v->modificabileDa($me)) {
    redirect('patenti.pending&err');
}

if (isset($_GET['si'])) {
    $t->tConferma   = time();
    $t->pConferma   = $me->id;
    $m = new Email('confermapatente', 'Conferma patente: ' . $t->codice());
    $m->da = $me; 
    $m->a = $t->volontario();
    $m->_NOME    = $t->volontario()->nome;
    $m->_PATENTE = $t->codice();
    $m->invia();
} else {
    $m = new Email('negazionepatente', 'Negazione patente: ' . $t->codice());
    $m->da = $me; 
    $m->a = $t->volontario();
    $m->_NOME    = $t->volontario()->nome;
    $m->_PATENTE = $t->codice();
    $m->invia();
    $t->cancella();
}

redirect('patenti.pending&ok');