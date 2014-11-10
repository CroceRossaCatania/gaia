<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
controllaParametri(['id'], 'us.dash&err');

$f = $_GET['id'];
$v = Utente::id($f);

/* Verifico di poter lavorare sull'utente */

proteggiDatiSensibili($v, [APP_SOCI, APP_PRESIDENTE]);
$elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);

if(!$v->modificabileDa($me)) {
	redirect('errore.permessi&cattivo');
}

if($v->volontario()) {
	redirect('errore.permessi&cattivo');
}

$app = $v->appartenenzaAttuale();
if(!$app || !in_array($app->comitato()->id, $elenco)) {
	redirect('errore.permessi&cattivo');
}

/* Verifico che la richiesta non sia già stata fatta */
$t = $v->tesserinoRichiesta();

if($t) {
	redirect('presidente.soci.ordinari&tesgia');
}

/* Creo la richiesta vera a propria */

$ora = time();

$t = new TesserinoRichiesta();
$t->volontario 	= $v;
$t->tipo 		= RILASCIO;
$t->stato 		= RICHIESTO;
$t->pRichiesta 	= $me;
$t->tRichiesta 	= $ora;
$t->timestamp 	= $ora;
$t->struttura	= $v->unComitato()->regionale()->oid();

$m = new Email('tesserinoRichiesto', 'Richiesta tesserino effettuata');
$m->a 			= $v;
$m->_NOME       = $v->nomeCompleto();
$m->accoda();

redirect('presidente.soci.ordinari&tok');
