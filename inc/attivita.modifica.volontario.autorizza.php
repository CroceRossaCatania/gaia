<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$parametri = array('turno', 'v');
controllaParametri($parametri, 'utente.me&err');

$turno = Turno::id($_GET['turno']);
$attivita = $turno->attivita();
paginaAttivita($attivita);

$v = Volontario::id($_GET['v']);

$p = Partecipazione::filtra([['turno', $turno],['volontario', $v]]);
$aut = Autorizzazione::by('partecipazione', $p[0]);
$aut->concedi();

$cal = new ICalendar();
$cal->genera($attivita->id, $turno->id);

$m = new Email('autorizzazioneConcessa', "Autorizzazione CONCESSA: {$a->nome}, {$turno->nome}" );
	$m->a = $v;
	$m->da = $attivita->referente();
	$m->_NOME       = $aut->partecipazione()->volontario()->nome;
	$m->_ATTIVITA   = $attivita->nome;
	$m->_TURNO      = $turno->nome;
	$m->_DATA      = $turno->inizio()->format('d-m-Y H:i');
	$m->_LUOGO     = $attivita->luogo;
	$m->_REFERENTE   = $attivita->referente()->nomeCompleto();
	$m->_CELLREFERENTE = $attivita->referente()->cellulare();
	$m->allega($cal);
	$m->invia();

redirect("attivita.scheda&id={$attivita->id}&turno={$turno->id}&riapri={$turno->id}");

?>
