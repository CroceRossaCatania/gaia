<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(array('id'), 'autoparco.veicoli&err');
$veicolo = $_GET['id'];
$veicolo = Veicolo::id($veicolo);

$rifornimento = new Rifornimento();

$rifornimento->veicolo = $veicolo->id;
$rifornimento->km = $_POST['inputKm'];

$data = @DateTime::createFromFormat('d/m/Y', $_POST['inputData']);
$data = @$data->getTimestamp();
$rifornimento->data = $data;

$rifornimento->tRegistra = time();
$rifornimento->pRegistra = $me;

$costo = (float) $_POST['inputCosto'];
$costo = round($costo, 2);
$rifornimento->costo = $costo;

$litri = (float) $_POST['inputLitri'];
$litri = round($litri, 2);
$rifornimento->litri = $litri;

$rifornimento->timestamp = time();

redirect('autoparco.veicoli&rifOk');