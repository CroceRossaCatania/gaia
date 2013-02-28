<?php

/*
 * ©2012 Croce Rossa Italiana
 */

define('UOMO',  1);
define('DONNA', 0);

/* Tipologie/stati delle persone */
define('PERSONA',   0);
define('ASPIRANTE', 1);
define('VOLONTARIO',2);

/* Tipologia appartenenza gruppo */
define('MEMBRO_PENDENTE',       0);
define('MEMBRO_VOLONTARIO',     2);
define('MEMBRO_MODERATORE',     3);
define('MEMBRO_PRESIDENTE',     4);

$conf['membro'] = [
    0   =>  'Pendente',
    2   =>  'Volontario',
    3   =>  'Moderatore',
    4   =>  'Presidente'
];

/* Tipologie di titolo */
define('TITOLO_PERSONALE',      0);
define('TITOLO_PATENTE_CIVILE', 1);
define('TITOLO_PATENTE_CRI',    2);
define('TITOLO_STUDIO',      	3);
define('TITOLO_CRI',            4);

/* Privacy servizi */
define('ATTIVITA_PRIVATA',		0);
define('ATTIVITA_PUBBLICA',		1);

/*Gruppo Sanguigno*/
$conf['sangue_gruppo'] = [
    0   =>  '-',
    10  =>  '0 Rh+',
    11  =>  '0 Rh-',
    20  =>  'A Rh+',
    21  =>  'A Rh-',
    30  =>  'B Rh+',
    31  =>  'B Rh-',
    40  =>  'AB Rh+',
    41  =>  'AB Rh-'
];

/* Avatar, dimensioni */
$conf['avatar'] = [
    10  =>  [75,    75],
    20  =>  [150,   150],
    80  =>  [750,   750]
];

$conf['titoli'] = [
	/*
	num =>  [denominazione,		       verifica, data,  data_obbl] */
	0	=>	['Competenza personale',	false,	false,	false],
	1	=>	['Patente Civile',             	false,	true,	false],
	2	=>	['Patente CRI',             	true,	true,	true],
	3	=>	['Titolo di studio',		false,  true,   false],
	4 	=>	['Titolo di Croce Rossa',	true,	true,	false]
];