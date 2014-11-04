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

/* Verifico esistenza di un tesserino valido e che la richiesta di duplicato non sia già stata fatta */

$gia = true;
$t = TesserinoRichiesta::filtra([
    ['volontario', $v]
    ]);
foreach($t as $tesserino) {
    if ($tesserino->stato < INVALIDATO &&  $tesserino->stato != RIFIUTATO) {
         $gia = false;
    }
}

if($gia) {
	redirect('presidente.soci.ok&gia');
}

if(!$me->fototessera() || $me->fototessera()->stato == FOTOTESSERA_PENDING) {
	redirect('presidente.soci.ok&nofoto');
}

/* Invalido precedente */
$motivo = "Richiesto duplicato";
$tesserino = $v->invalidaTesserino($motivo);

/* Creo la richiesta vera a propria */

$ora = time();

if ( $tesserino ){

	$t = new TesserinoRichiesta();
	$t->volontario 	= $v;
	$t->tipo 		= DUPLICATO;
	$t->stato 		= RICHIESTO;
	$t->pRichiesta 	= $me;
	$t->tRichiesta 	= $ora;
	$t->timestamp 	= $ora;
	$t->struttura	= $v->unComitato()->regionale()->oid();

	$m = new Email('tesserinoDuplicato', 'Richiesta duplicato tesserino effettuata');
	$m->a 			= $v;
	$m->_NOME       = $v->nomeCompleto();
	$m->accoda();

	redirect('presidente.soci.ok&tok');
}

redirect('presidente.soci.ok&tdupko');
