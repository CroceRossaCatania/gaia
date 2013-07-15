<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
$a = $_GET['id'];
$a = new Attivita($a);
paginaAttivita($a);

$turno = $_POST['turno'];
$turno = new Turno($turno);

foreach ( $_POST['volontari'] as $v ) {
    
    $v = new Volontario($v);
    if ( $turno->partecipa($v) ) { continue; }
    
    $p = new Partecipazione();
    $p->stato       = PART_OK;
    $p->volontario  = $v;
    $p->turno       = $turno;
    $p->timestamp   = time();
    $p->tConferma   = time();
    $p->pConferma   = $me;
    
    $m = new Email('aggiuntoattivita', "Partecipazione  {$a->nome}");
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
    
}

redirect("attivita.scheda&id={$a->id}&turno={$turno->id}&riapri={$turno->id}");