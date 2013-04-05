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
 * =========== AUTORIZZAZIONE ========
 * ===================================
 */

define('AUT_PENDING',       10);
define('AUT_NO',            20);
define('AUT_OK',            30);

$conf['autorizzazione'] = [
    AUT_PENDING         =>  'In attesa',
    AUT_OK              =>  'Concessa',
    AUT_NO              =>  'Negata'
];



/*
 * ===================================
 * =========== PARTECIPAZIONE ========
 * ===================================
 */


define('PART_PENDING',      10);
define('PART_NO',           20);
define('PART_OK',           30);

$conf['partecipazione'] = [
    PART_PENDING        =>  'In attesa',
    PART_NO             =>  'Negata',
    PART_OK             =>  'Concessa'
];



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



/*
 * ===================================
 * =========== FINE APP. =============
 * ===================================
 */

/* 0 => Nessuna scadenza! */
define('PROSSIMA_SCADENZA', 0);


/*
 * ===================================
 * =========== DELEGATI ==============
 * ===================================
 */
define('APP_ATTIVITA',      10);
define('APP_PROTOCOLLO',    20);

$conf['applicazioni'] = [
    APP_ATTIVITA    =>  "Attività",
    APP_PROTOCOLLO  =>  "Protocollo"
];

/*
 * ===================================
 * =========== APP_ATTIVITA ==========
 * ===================================
 */
define('APP_ATTIVITA_TUTTO',     0);
define('APP_ATTIVITA_PIAZZA',   10);
define('APP_ATTIVITA_CORSI',    20);

$conf['app_attivita'] = [
    APP_ATTIVITA_TUTTO  =>  'Tutte le attività',
    APP_ATTIVITA_PIAZZA =>  'Attività di Piazza',
    APP_ATTIVITA_CORSI  =>  'Corsi e formazione'
];


/*
 * ===================================
 * =========== TRAFERIMENTI ==========
 * ===================================
 */
define('TRASF_NEGATO',       10);
define('TRASF_INCORSO',      20);
define('TRASF_OK',           30);
define('TRASF_AUTO',         40);

$conf['trasferimenti'] = [
    TRASF_NEGATO        =>  'Negato',
    TRASF_INCORSO       =>  'In corso',
    TRASF_OK            =>  'Con successo',
    TRASF_AUTO          =>  'Eseguito automaticamente'
];

/*
 * ===================================
 * =========== RISERVE ======== ==========
 * ===================================
 */
define('RISERVA_NEGATA',       10);
define('RISERVA_INCORSO',      20);
define('RISERVA_OK',           30);
define('RISERVA_SCAD',         40);

$conf['riserve'] = [
    RISERVA_NEGATA        =>  'Negata',
    RISERVA_INCORSO       =>  'In corso',
    RISERVA_OK          =>  'In riserva',
    RISERVA_SCAD          =>  'Scaduta'
];