<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

$id     = $_GET['id'];
$t      = new TitoloPersonale($id);

if (isset($_GET['si'])) {
    $t->tConferma   = time();
    $t->pConferma   = $me->id;
    $m = new Email('confermatitolo', 'Conferma titolo: ' . $t->titolo()->nome);
    $m->a = $t->volontario();
    $m->_NOME       = $t->volontario()->nome;
    $m->_TITOLO   = $t->titolo()->nome;
    $m->invia();
} else {
    $m = new Email('negazionetitolo', 'Negazione titolo: ' . $t->titolo()->nome);
    $m->a = $t->volontario();
    $m->_NOME       = $t->volontario()->nome;
    $m->_TITOLO   = $t->titolo()->nome;
    $m->invia();
    $t->cancella();
}

redirect('admin.titoliPending');