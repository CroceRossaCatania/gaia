<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
controllaParametri(['id'], 'us.dash&err');

$f = $_GET['id'];
$t = Volontario::id($f);
$t->tesserino()->anteprima();

