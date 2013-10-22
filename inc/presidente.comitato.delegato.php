<?php

/*
 * ©2013 Croce Rossa Italiana
 */

$c = $_POST['oid'];
$c = GeoPolitica::daOid($c);

paginaApp([APP_PRESIDENTE]);

$persona = $_POST['persona'];
$persona = Volontario::id($persona);

$app        = (int) $_POST['applicazione'];
$app_nome   = $conf['applicazioni'][$app];

/*
 * Crea il nuovo delegato...
 */
$d = new Delegato();
$d->estensione      = $c->_estensione();
$d->comitato        = $c->id;
$d->applicazione    = $app;
$d->dominio         = null;
$d->inizio          = time();
$d->pConferma       = $me->id;
$d->tConferma       = time();
$d->volontario      = $persona->id;

/*
 * Invia la mail di notifica
 */
$m = new Email('delegatoGenerico', "{$app_nome} in {$c->nomeCompleto()}");
$m->da  = $me;
$m->a   = $d->volontario();
$m->_NOME           = $d->volontario()->nome;
$m->_VOLONTARIO     = $me->nomeCompleto();
$m->_APPLICAZIONE   = $app_nome;
$m->_COMITATO       = $c->nomeCompleto();
$m->invia();

/*
 * Torna alla pagina precedente...
 */
redirect("presidente.comitato&oid={$c->oid()}&ok&back=app_{$app}");