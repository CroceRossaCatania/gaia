<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(array('id'), 'autoparco.veicoli&err');

$manutenzione = $_GET['id'];
$manutenzione = Manutenzione::id($manutenzione);

$veicolo = $manutenzione->veicolo();

$manutenzione->cancella();

redirect('autoparco.veicolo.manutenzione&del&id='. $veicolo);