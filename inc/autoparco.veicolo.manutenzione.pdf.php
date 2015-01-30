<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);
controllaParametri(['id'], 'autoparco.veicoli&err');
$manutenzione = $_GET['id'];
$manutenzione = Manutenzione::id($manutenzione);
$veicolo = $manutenzione->veicolo();

proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

$p = new PDF("manutenzioni","manutenzione{$_GET['id']}.pdf");

$p->_TITOLO = "Manutenzione {$_GET['id']}";
$p->_TIPO = $conf['man_tipo'][$manutenzione->tipo];
$p->_KM = $manutenzione->km;
$p->_DATA = date('d/m/Y', $manutenzione->tIntervento);
$p->_DESCRIZIONE = $manutenzione->intervento;
$p->_AZIENDA = $manutenzione->azienda();
$p->_NOFAT = $manutenzione->fattura();
$p->_COSTO = $manutenzione->costo;

$f = $p->salvaFile();
$f->download();