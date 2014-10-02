<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);
controllaParametri(array('id'), 'autoparco.autoparchi&err');

/* Ognuno può modificare solo il suo autoparco !!!creare proteggi autoparco !!! */

$autoparco = $_GET['id'];
$autoparco = Autoparco::id($autoparco);

/* Verifico se sono presenti veicoli in questo autoparco e li tolgo */

$collocazioni = Collocazione::filtra([['autoparco', $autoparco]]);
foreach ( $collocazioni as $collocazione ){
	$collocazione->cancella();
}

$autoparco->cancella();

redirect('autoparco.autoparchi&del');