<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$a = $_GET['a'];

$app = Appartenenza::id($a);
$v = $app->volontario;
$app->cancella();

redirect('presidente.utente.visualizza&id=' . $v);
