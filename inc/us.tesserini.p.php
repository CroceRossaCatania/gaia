<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
controllaParametri(['id'], 'us.dash&err');

$t = $_GET['id'];
$t = TesserinoRichiesta::id($t);
$t->generaTesserino()->anteprima();

redirect('presidente.soci.ok&nofoto');

