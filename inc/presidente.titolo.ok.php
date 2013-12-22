<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

controllaParametri(array('id'), 'presidente.titoli&err');

$id     = $_GET['id'];
$t      = TitoloPersonale::id($id);
$v      = $t->volontario();
if (!$v->modificabileDa($me)) {
    redirect('presidente.titoli&err');
}

if (isset($_GET['si'])) {
    $t->tConferma   = time();
    $t->pConferma   = $me->id;
    $m = new Email('confermatitolo', 'Conferma titolo: ' . $t->titolo()->nome);
    $m->da = $me; 
    $m->a = $t->volontario();
    $m->_NOME       = $t->volontario()->nome;
    $m->_TITOLO   = $t->titolo()->nome;
    $m->invia();
} else {
    $m = new Email('negazionetitolo', 'Negazione titolo: ' . $t->titolo()->nome);
    $m->da = $me; 
    $m->a = $t->volontario();
    $m->_NOME       = $t->volontario()->nome;
    $m->_TITOLO   = $t->titolo()->nome;
    $m->invia();
    $t->cancella();
}

redirect('presidente.titoli&ok');