<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/* Modalità debug */
$conf['debug']  =   true;

$conf['version']	= 1.1;
$conf['name']		= 'Gaia';
$conf['vendor']		= 'Croce Rossa Italiana';
$conf['copyright']	= '©2013 Croce Rossa Italiana';
$conf['status']		= 'Online and working';
$conf['docs']		= 'No publicy available docs yet.';

$conf['timezone']       = 'Europe/Rome';

/* Invio email */
$conf['smtp'] = [
    'host'      =>  'localhost',
    'username'  =>  'informatica',
    'password'  =>  'sanbitter',
    'debug'     =>  false
];

/* Pagine nelle quali mostrare la slide */
$conf['slide']          = ['home'];

$conf['mesi']           = [null, 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];

$conf['attivita']['colore_pubbliche'] = '333';
