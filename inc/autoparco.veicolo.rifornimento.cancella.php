<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(['id'], 'autoparco.veicoli&err');

$rifornimento = $_GET['id'];
$rifornimento = Rifornimento::id($rifornimento);

$veicolo = $rifornimento->veicolo();

$rifornimento->cancella();

redirect('autoparco.veicolo.rifornimenti&del&id='. $veicolo);