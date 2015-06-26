<?php

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(['oid']);
paginaPrivata();


$c = $_GET['oid'];
$c = GeoPolitica::daOid($c);

paginaApp(APP_PRESIDENTE, [$c]);

if ( ! $c instanceOf Locale ) {
	throw new Errore(1000);
	die();
}

$c->obbligoQuota = (int) ((bool) $_GET['r']);

redirect("presidente.comitato&oid=" . $c->oid());
