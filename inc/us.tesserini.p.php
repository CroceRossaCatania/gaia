<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
controllaParametri(['id'], 'us.dash&err');

$f = $_GET['id'];
$t = Volontario::id($f);
if($t->tesserino()) {
	$t->tesserino()->anteprima();
}
redirect('presidente.soci.ok&nofoto');

