<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_PRESIDENTE]);

$parametri = array('oid', 'id');
controllaParametri($parametri);

$c = $_GET['oid'];
$c = GeoPolitica::daOid($c);

$d = $_GET['id'];
$d = Delegato::id($d);

$app        = (int) $d->applicazione;
$app_nome   = $conf['applicazioni'][$app];

$d->fine = time();

$m = new Email('delegatoGenericoFine', "Fine autorizzazione {$app_nome}");
$m->da  = $me;
$m->a   = $d->volontario();
$m->_NOME           = $d->volontario()->nome;
$m->_APPLICAZIONE   = $app_nome;
$m->_COMITATO       = $c->nomeCompleto();
$m->invia();

redirect("presidente.comitato&oid={$c->oid()}&ok&back=app_{$app}");