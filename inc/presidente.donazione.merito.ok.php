<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

controllaParametri(array('id'), 'presidente.donazioni.merito&err');

$id     = $_GET['id'];
$t      = DonazioneMerito::id($id);
$v      = $t->volontario();
if (!$v->modificabileDa($me)) {
    redirect('presidente.donazioni.merito&err');
}

if (isset($_GET['si'])) {
    $t->tConferma   = time();
}

redirect('presidente.donazioni.merito&ok');
