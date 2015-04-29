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

/* Invio email annullamento quota */

$m = new Email('annullaQuota', 'Annullamento registrazione agamento quota');
$m->a 		 = $v;
$m->da 		 = $me;
$m->_NUMERO	 = $q->progressivo();
$m->_NOME 	 = $v->nomeCompleto();
$m->_ANNULLATORE = $me->nomeCompleto();
$m->_IMPORTO = soldi($q->quota);
$m->_DATA	 = $q->data()->format('d/m/Y');
$m->invia();

redirect('us.dash&annullata');

?>
