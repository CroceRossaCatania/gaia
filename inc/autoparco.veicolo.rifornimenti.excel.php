<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(['id'], 'autoparco.veicoli&err');
$veicolo = $_GET['id'];
$veicolo = Veicolo::id($veicolo);

proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

$rifornimenti = Rifornimento::filtra([['veicolo', $veicolo]],'data DESC');

$excel = new Excel();

$excel->intestazione([
	'Km',
	'Data',
	'Litri',
	'Costo',
	'Registrato da'
]);

foreach ($rifornomenti as $rifornimento) {
	$excel->aggiungiRiga([
		$rifornimento->km,
        date('d/m/Y', $rifornimento->data),
        $rifornimento->litri,
        $rifornimento->costo,
        $rifornimento->volontario()->nomeCompleto()
	]);
}

$excel->genera("Rifornimenti_Veicolo_{$_GET['id']}.xls");

$excel->download();
