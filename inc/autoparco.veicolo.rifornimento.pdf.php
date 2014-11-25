<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);
controllaParametri(['id'], 'autoparco.veicoli&err');
$rifornimento = $_GET['id'];
$rifornimento = Rifornimento::id($rifornimento);
$veicolo = $rifornimento->veicolo();

proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

$p = new PDF("rifornimenti","rifornimento{$_GET['id']}.pdf");

$p->_TITOLO = "Rifornimento {$_GET['id']}";
$p->_KM = $rifornimento->km;
$p->_DATA = date('d/m/Y', $rifornimento->data);
$p->_LITRI = $rifornimento->litri;
$p->_COSTO = $rifornimento->costo;
$p->_REG = $rifornimento->volontario()->nomeCompleto();


$f = $p->salvaFile();
$f->download();
