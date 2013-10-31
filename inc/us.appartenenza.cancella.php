<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$a = $_GET['a'];

$app = Appartenenza::id($a);
$v = $app->volontario;

foreach(Estensione::filtra([['appartenenza', $app]]) as $estensione){
	$estensione->cancella();
}

foreach(Trasferimento::filtra([['appartenenza', $app]]) as $trasferimento){
	$trasferimento->cancella();
}

foreach(Riserva::filtra([['appartenenza', $app]]) as $riserva){
	$riserva->cancella();
}

$app->cancella();

redirect('presidente.utente.visualizza&id=' . $v);
