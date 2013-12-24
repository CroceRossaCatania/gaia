<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

controllaParametri(array('id'), 'presidente.utenti&errGen');

$v = Volontario::id($_GET['id']);
$v->zipDocumenti()->download();