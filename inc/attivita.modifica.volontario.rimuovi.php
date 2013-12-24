<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$parametri = array('turno', 'v');
controllaParametri($parametri, 'utente.me&err');

$turno = $_GET['turno'];
$turno = Turno::id($turno);
$a = $turno->attivita();
paginaAttivita($a);


$v = $_GET['v'];
$v = Volontario::id($v);

$p = Partecipazione::filtra([['turno', $turno],['volontario', $v]]);
$p[0]->cancella();

$m = new Email('rimossoattivita', "Partecipazione  {$a->nome}");
$m->a               = $v;
$m->da              = $me;
$m->_NOME           = $v->nomeCompleto();
$m->_AUTORE         = $me->nomeCompleto();
$m->_ATTIVITA       = $a->nome;
$m->_TURNO          = $turno->nome;
$m->_DATA           = $turno->inizio()->inTesto();
$m->_LUOGO          = $a->luogo;
$m->_REFERENTE      = $a->referente()->nomeCompleto();
$m->_CELLREFERENTE  = $a->referente()->cellulare();
$m->invia();

redirect("attivita.scheda&id={$a->id}&turno={$turno->id}&riapri={$turno->id}");

?>
