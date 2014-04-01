<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
controllaParametri(['id'], 'us.dash&err');

$f = $_GET['id'];
$v = Volontario::id($f);

/* Verifico di poter lavorare sull'utente */

proteggiDatiSensibili($v, [APP_SOCI, APP_PRESIDENTE]);
$elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);

if(!$v->modificabileDa($me)) {
	redirect('errore.permessi&cattivo');
}

if($v->ordinario()) {
	redirect('errore.permessi&cattivo');
}

$app = $v->appartenenzaAttuale();
if(!$app || !in_array($app->comitato()->id, $elenco)) {
	redirect('errore.permessi&cattivo');
}

/* Verifico che la richiesta non sia già stata fatta */
$t = $v->tesserinoRichiesta();

if($t) {
	redirect('presidente.soci.ok&gia');
}

if(!$me->fototessera() || $me->fototessera()->stato == FOTOTESSERA_PENDING) {
	redirect('presidente.soci.ok&nofoto');
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

// bisogna inserire invio email a volontario

redirect('presidente.soci.ok&tok');
