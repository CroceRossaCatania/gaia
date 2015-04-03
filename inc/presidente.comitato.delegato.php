<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$parametri = array('oid', 'persona', 'applicazione');
controllaParametri($parametri);

$c = $_REQUEST['oid'];
$c = GeoPolitica::daOid($c);

paginaApp([APP_PRESIDENTE]);

$persona = $_REQUEST['persona'];
$persona = Volontario::id($persona);

$app        = (int) $_REQUEST['applicazione'];
$appnome   = $conf['applicazioni'][$app];

/*
 * Crea il nuovo delegato...
 */

$deleghe = Delegato::filtra([
	['volontario', $persona->id],
	['applicazione', $app],
	['comitato', $c->oid()]
	]);

foreach($deleghe as $delega) {
	if ($delega->attuale()) {
		redirect("presidente.comitato&oid={$c->oid()}&double&back=app_{$app}");
	}
}

$d = new Delegato();
$d->estensione      = $c->_estensione();
$d->comitato        = $c->oid();
$d->applicazione    = $app;
$d->dominio         = null;
$d->inizio          = time();
$d->pConferma       = $me->id;
$d->tConferma       = time();
$d->volontario      = $persona->id;

/*
 * Invia la mail di notifica
 */
$m = new Email('delegatoGenerico', "{$appnome} in {$c->nomeCompleto()}");
$m->da  = $me;
$m->a   = $d->volontario();
$m->_NOME           = $d->volontario()->nome;
$m->_VOLONTARIO     = $me->nomeCompleto();
$m->_APPLICAZIONE   = $appnome;
$m->_COMITATO       = $c->nomeCompleto();
$m->invia();

/*
 * Torna alla pagina precedente...
 */
redirect("presidente.comitato&oid={$c->oid()}&ok&back=app_{$app}");