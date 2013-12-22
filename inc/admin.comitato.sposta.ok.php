<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$t = GeoPolitica::daOid($_GET['oid']);
$c = GeoPolitica::daOid($_POST['inputComitato']);
$estensione = $t->_estensione();
if($estensione==EST_UNITA){
	$t->locale = $c;
}elseif($estensione==EST_LOCALE){
	$t->provinciale = $c;
}elseif($estensione==EST_PROVINCIALE){
	$t->regionale = $c;
}
GeoPolitica::rigeneraAlbero();
redirect('admin.comitati&spostato');
