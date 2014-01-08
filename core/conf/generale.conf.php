<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/* Modalità debug */
$conf['debug']  =   true;

$conf['versione']			= 1.1;
$conf['nome']				= 'Gaia';
$conf['organizzazione']		= 'Croce Rossa Italiana';
$conf['copyright']			= '©2011 Croce Rossa Italiana';
$conf['stato']				= 'Ok';
$conf['documentazione']		= 'https://github.com/CroceRossaCatania/gaia/wiki/API';

/* Timezone */
$conf['timezone']       = 'Europe/Rome';

/* Email */
$conf['default_email_nome']		= 'Supporto GAIA';
$conf['default_email_email']	= 'supporto@gaia.cri.it';


/* UI: Pagine nelle quali mostrare la slide */
$conf['slide'] = ['home'];

/* Mesi in Italiano */
$conf['mesi'] = [null, 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];

/* Attivita, colori */
$conf['attivita']['colore_pubbliche'] 	= '7E7AED';
$conf['attivita']['colore_mie']			= '14CC00';
$conf['attivita']['colore_scoperto'] 	= 'B20000';
$conf['attivita']['colore_anonimi'] 	= '3135B0';