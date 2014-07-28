<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);
/* Ulteriore controllo se non sono resp locale o superiore non posso aggiungere veicolo */

controllaParametri(array('id'), 'autoparco.veicoli&err');
$veicolo = $_GET['id'];
$veicolo = Veicolo::id($veicolo);
$veicolo->cancella();

redirect('autoparco.veicoli&del');