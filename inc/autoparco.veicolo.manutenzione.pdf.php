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

