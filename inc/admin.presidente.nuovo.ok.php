<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$v = $_GET['v'];
$c = $_GET['oid'];

$c = GeoPolitica::daOid($c);
$v = new Volontario($v);

if ( $c->unPresidente() ) {
    if ($c->unPresidente()->attuale()){
    	redirect('admin.presidenti&duplicato');
    }
}

/* Creo la nuova appartenenza... */
$a = new Delegato();
$a->volontario  = $v;
$a->comitato    = $c->id;
$a->estensione  = $c->_estensione();
$a->inizio      = time();
$a->fine        = PROSSIMA_SCADENZA;
$a->applicazione= APP_PRESIDENTE;
$a->conferma    = $me->id;
$a->timestamp   = time();
$a->pConferma 	= $me->id;
$a->tConferma	= time();

redirect('admin.presidenti&new');