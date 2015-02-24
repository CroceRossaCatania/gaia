<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(['id'], 'autoparco.veicoli&err');
$veicolo = $_GET['id'];
$veicolo = Veicolo::id($veicolo);

proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

$manutenzioni = Manutenzione::filtra([['veicolo', $veicolo]],'tIntervento DESC');

$excel = new Excel();

$excel->intestazione([
	'Tipo',
	'Data',
	'Km',
	'Descrizione',
	'Azienda',
	'Numero Fattura',
	'Costo'
]);

foreach ( $manutenzioni as $manutenzione ){ 
	$excel->aggiungiRiga([
		$conf['man_tipo'][$manutenzione->tipo],
		date('d/m/Y', $manutenzione->tIntervento),
		$manutenzione->km,
		$manutenzione->intervento,
		$manutenzione->azienda(),
		$manutenzione->fattura(),
		$manutenzione->costo
	]);
}

$excel->genera("Manutezioni_Veicolo_{$_GET['id']}.xls");

$excel->download();
