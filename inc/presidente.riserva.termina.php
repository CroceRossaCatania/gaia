<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

controllaParametri(['id'], 'presidente.riserva&err');

$t = $_GET['id'];
$t = Riserva::id($t);
$t->termina();

redirect("presidente.utenti.riserve");
