<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(['id'], 'autoparco.veicoli&err');

$data = @DateTime::createFromFormat('d/m/Y', $_POST['inputData']);
$data = @$data->getTimestamp();

if ( isset($_GET['mod']) ){ 

	$rifornimento = Rifornimento::id($_GET['id']);
    $libretto = null;
    $mod = "rifMod";
    $veicolo = $rifornimento->veicolo();

    if ( !$veicolo->validaRifornimento($data,$_POST['inputKm'])){ 
		redirect('autoparco.veicolo.rifornimento.nuovo&old&id='.$rifornimento->veicolo());
	}

}else{

	$veicolo = $_GET['id'];
	$veicolo = Veicolo::id($veicolo);
	$ultimorifornimento = $veicolo->ultimorifornimento();
	echo "Km: ", $_POST['inputKm'], " Data: ", $data;
	echo "<br/> Prima: ";
	echo $veicolo->primaRifornimento($data,$_POST['inputKm'])->km, " - Data: ", $veicolo->primaRifornimento($_POST['inputKm'])->data;
	echo "<br/>";
	echo "Dopo: ";
    echo $veicolo->dopoRifornimento($data,$_POST['inputKm'])->km, " - Data: ", $veicolo->dopoRifornimento($_POST['inputKm'])->data;
    echo "<br/>";
    echo "Valido: ";
    echo $veicolo->validaRifornimento($data,$_POST['inputKm']);
    exit();

	if ( !$veicolo->validaRifornimento($data,$_POST['inputKm'])){ 
		redirect('autoparco.veicolo.rifornimento.nuovo&old&id='.$veicolo);
	}

	$rifornimento = new Rifornimento();
    $mod = "rifOk";

}

$rifornimento->veicolo = $veicolo;

$rifornimento->km = $_POST['inputKm'];

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

redirect('autoparco.veicoli&'.$mod);