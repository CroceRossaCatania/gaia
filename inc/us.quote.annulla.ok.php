<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

controllaParametri(array('id'), 'us.dash&err');

$id = $_GET['id'];
$q = Quota::id($id);
$v = $q->volontario();

$t = $q->tesseramento();
if (!$t || !$t->aperto()) {
	redirect('errore.permessi&cattivo');
}

proteggiDatiSensibili($v, [APP_SOCI, APP_PRESIDENTE]);

if ($q->annullata()) {
	redirect('us.dash&giaAnn');
}

$q->pAnnullata = $me;
$q->tAnnullata = time();

redirect('us.dash&annullata');

?>
