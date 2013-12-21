<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
$parametri = array('v', 'id');
controllaParametri($parametri, 'admin.presidenti&err');
$v = $_GET['v'];
$c = $_GET['oid'];

$c = GeoPolitica::daOid($c);
$v = Volontario::id($v);

if ( $c->unPresidente() ) {
    redirect('admin.presidenti&duplicato');
}

/* Creo la nuova appartenenza... */
$a = new Delegato();
$a->volontario  = $v;
$a->comitato    = $c->oid();
$a->estensione  = $c->_estensione();
$a->inizio      = time();
$a->fine        = PROSSIMA_SCADENZA;
$a->applicazione= APP_PRESIDENTE;
$a->conferma    = $me->id;
$a->timestamp   = time();
$a->pConferma 	= $me->id;
$a->tConferma	= time();

$m = new Email('nominaPresidente', 'Nomina Presidente: ' . $c->nomeCompleto());
$m->da = $me;
$m->a = $v;
$m->_NOME       = $v->nomeCompleto();
$m->_COMITATO = $c->nomeCompleto();
$m->invia();

redirect('admin.presidenti&new');
