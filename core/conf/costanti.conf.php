<?php

/*
 * ©2012 Croce Rossa Italiana
 */

/*
 * ===================================
 * =========== ANAGRAFICA ============
 * ===================================
 */

define('UOMO',  1);
define('DONNA', 0);

/* Tipologie/stati delle persone */
define('PERSONA',   0);
define('ASPIRANTE', 1);
define('VOLONTARIO',2);

/*
 * ===================================
 * =========== APPARTENENZE ==========
 * ===================================
 */

/* Tipologia appartenenza gruppo */
define('MEMBRO_TRASF_NEGATO',   10);
define('MEMBRO_TRASF_IN_CORSO', 20);
define('MEMBRO_PENDENTE',       30);
define('MEMBRO_VOLONTARIO',     40);
define('MEMBRO_MODERATORE',     50);
define('MEMBRO_DIPENDENTE',     60);
define('MEMBRO_PRESIDENTE',     70);

/* Definizioni in stringa */
$conf['membro'] = [
    MEMBRO_TRASF_NEGATO     =>  'Trasferimento negato',
    MEMBRO_TRASF_IN_CORSO   =>  'Trasferimento in corso',
    MEMBRO_PENDENTE         =>  'Pendente',
    MEMBRO_VOLONTARIO       =>  'Volontario',
    MEMBRO_MODERATORE       =>  'Moderatore',
    MEMBRO_DIPENDENTE       =>  'Dipendente',
    MEMBRO_PRESIDENTE       =>  'Presidente'
];


/*
 * ===================================
 * =========== ATTIVITA ==============
 * ===================================
 */

/* Privacy servizi */
define('ATTIVITA_PRIVATA',		0);
define('ATTIVITA_PUBBLICA',		1);


/*
 * ===================================
 * =========== SANGUE ================
 * ===================================
 */

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


/*
 * ===================================
 * =========== AVATAR ================
 * ===================================
 */

/* Avatar, dimensioni */
$conf['avatar'] = [
    10  =>  [75,    75],
    20  =>  [150,   150],
    80  =>  [750,   750]
];


/*
 * ===================================
 * =========== DOCUMENTI =============
 * ===================================
 */

/* Documenti, dimensioni dell'anteprima */
$conf['docs_t'] = [200, 200];

/* Tipologie di documenti */
define('DOC_CARTA_IDENTITA',    10);
define('DOC_PATENTE_CIVILE',    20);
define('DOC_QUOTA_ASSOCIATIVA', 30);
define('DOC_CODICE_FISCALE',    40);
define('DOC_PATENTE_CRI',       50);

/* Denominazioni */
$conf['docs_tipologie'] = [
    DOC_CARTA_IDENTITA      =>  'Carta d\'identità',
    DOC_PATENTE_CIVILE      =>  'Patente civile',
    DOC_QUOTA_ASSOCIATIVA   =>  'Quota associativa',
    DOC_CODICE_FISCALE      =>  'Codice fiscale',
    DOC_PATENTE_CRI         =>  'Patente CRI'
];


/*
 * ===================================
 * =========== TITOLI ================
 * ===================================
 */

/* Tipologie di titolo */
define('TITOLO_PERSONALE',      0);
define('TITOLO_PATENTE_CIVILE', 1);
define('TITOLO_PATENTE_CRI',    2);
define('TITOLO_STUDIO',      	3);
define('TITOLO_CRI',            4);


$conf['titoli'] = [
	/*
	num =>  [denominazione,		       verifica, data,  data_obbl] */
	TITOLO_PERSONALE	=>	['Competenza personale',	false,	false,	false],
	TITOLO_PATENTE_CIVILE	=>	['Patente Civile',             	false,	true,	false],
	TITOLO_PATENTE_CRI	=>	['Patente CRI',             	true,	true,	true],
	TITOLO_STUDIO   	=>	['Titolo di studio',		false,  true,   false],
	TITOLO_CRI       	=>	['Titolo di Croce Rossa',	true,	true,	false]
];

