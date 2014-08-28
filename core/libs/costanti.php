<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/*
 * ===================================
 * =========== ANAGRAFICA ============
 * ===================================
 */

define('UOMO',  1);
define('DONNA', 0);

/* Definizioni in stringa */
$conf['sesso'] = [
    UOMO     =>  'Uomo',
    DONNA       =>  'Donna'
];

/* Tipologie/stati delle persone */
define('PERSONA',   0);
define('ASPIRANTE', 1);
define('VOLONTARIO',2);

$conf['statoPersona'] = [
    NULL        =>  'Nessuno',
    PERSONA     =>  'Persona',
    ASPIRANTE   =>  'Aspirante',
    VOLONTARIO  =>  'Volontario'
];

/* Un anno, un mese e un giorno */

define('ANNO',       31536000);
define('MESE',        2592000);
define('MESEEMEZZO',  3888000);
define('GIORNO',        86400);
define('DUEGIORNI',    172800);
define('ETAMINIMA', 441504000);


/*
 * ===================================
 * =========== APPARTENENZE ==========
 * ===================================
 */

/* Tipologia appartenenza gruppo */
define('MEMBRO_DIMESSO',            0);
define('MEMBRO_TRASFERITO',         1);
define('MEMBRO_ORDINARIO_DIMESSO',  2);
define('MEMBRO_APP_NEGATA',         3);
define('MEMBRO_ORDINARIO_PROMOSSO', 4);
define('MEMBRO_EST_TERMINATA',      5);
define('MEMBRO_TRASF_ANN',          9);
define('MEMBRO_TRASF_NEGATO',      10);
define('MEMBRO_EST_ANN',           14);
define('MEMBRO_EST_NEGATA',        15);
define('MEMBRO_ORDINARIO',         16);
define('SOGLIA_APPARTENENZE',      19);
define('MEMBRO_TRASF_IN_CORSO',    20);
define('MEMBRO_EST_PENDENTE',      25);
define('MEMBRO_PENDENTE',          30);
define('MEMBRO_ESTESO',            35);
define('MEMBRO_VOLONTARIO',        40);
define('MEMBRO_MODERATORE',        50);
define('MEMBRO_DIPENDENTE',        60);
define('MEMBRO_PRESIDENTE',        70);



/* Definizioni in stringa */
$conf['membro'] = [
    MEMBRO_TRASF_NEGATO         =>  'Trasferimento negato',
    MEMBRO_TRASF_ANN            =>  'Richiesta trasferimento annullata',
    MEMBRO_TRASFERITO           =>  'Membro Trasferito',
    MEMBRO_ORDINARIO_PROMOSSO   =>  'Socio Ordinario promosso ad Attivo',
    MEMBRO_ORDINARIO_DIMESSO    =>  'Membro Ordinario Dimesso',
    MEMBRO_EST_ANN              =>  'Richiesta estensione annullata',
    MEMBRO_EST_NEGATA           =>  'Estensione negata',
    MEMBRO_ORDINARIO            =>  'Membro Ordinario',
    MEMBRO_TRASF_IN_CORSO       =>  'Trasferimento in corso',
    MEMBRO_PENDENTE             =>  'Pendente',
    MEMBRO_EST_PENDENTE         =>  'Estensione richiesta',
    MEMBRO_VOLONTARIO           =>  'Volontario',
    MEMBRO_ESTESO               =>  'Volontario in estensione',
    MEMBRO_MODERATORE           =>  'Moderatore',
    MEMBRO_DIPENDENTE           =>  'Dipendente',
    MEMBRO_PRESIDENTE           =>  'Presidente',
    MEMBRO_DIMESSO              =>  'Dimesso',
    MEMBRO_EST_TERMINATA        =>  'Estensione terminata',
    MEMBRO_APP_NEGATA           =>  'Appartenenza negata'
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
define('AUT_NP',            15);
define('AUT_NO',            20);
define('AUT_OK',            30);

$conf['autorizzazione'] = [
    AUT_PENDING         =>  'In attesa',
    AUT_OK              =>  'Concessa',
    AUT_NO              =>  'Negata',
    AUT_NP              =>  'Mancata partecipazione turno'
];



/*
 * ===================================
 * =========== PARTECIPAZIONE ========
 * ===================================
 */


define('PART_RIT',           0);
define('PART_PENDING',      10);
define('PART_NO',           20);
define('PART_OK',           30);

$conf['partecipazione'] = [
    PART_RIT            =>  'Ritirato',
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
//define('DOC_QUOTA_ASSOCIATIVA', 30);
define('DOC_CODICE_FISCALE',    40);
define('DOC_PATENTE_CRI',       50);

/* Denominazioni */
$conf['docs_tipologie'] = [
    DOC_CARTA_IDENTITA      =>  'Carta d\'identità',
    DOC_PATENTE_CIVILE      =>  'Patente civile',
//    DOC_QUOTA_ASSOCIATIVA   =>  'Quota associativa',
    DOC_CODICE_FISCALE      =>  'Codice fiscale',
    DOC_PATENTE_CRI         =>  'Patente CRI'
];


/*
 * ===================================
 * ======== ESPLIRAZIONE =============
 * ===================================
 */
define('NON_ESPLORARE',         0);
define('ESPLORA_RAMI',          1);
define('ESPLORA_SOLO_FOGLIE',   2);

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
// define('APP_PROTOCOLLO',    20);
define('APP_PRESIDENTE',    30);
define('APP_OBIETTIVO',     40);
define('APP_CO',            50);
define('APP_SOCI',          60);
define('APP_PATENTI',       70);
define('APP_FORMAZIONE',    80);

$conf['applicazioni'] = [
    APP_ATTIVITA    =>  "Attività",
    // APP_PROTOCOLLO  =>  "Protocollo",
    APP_PRESIDENTE  =>  "Presidente",
    APP_OBIETTIVO   =>  "Obiettivo strategico",
    APP_CO          =>  "Centrale Operativa",
    APP_SOCI        =>  "Ufficio Soci",
    APP_PATENTI     => "Ufficio Patenti",
    APP_FORMAZIONE  => "Resp. Formazione"
];

/*
 * ===================================
 * =========== APP_ATTIVITA ==========
 * ===================================
 */

define('ATT_VIS_UNITA',         10);
define('ATT_VIS_LOCALE',        20);
define('ATT_VIS_PROVINCIALE',   30);
define('ATT_VIS_REGIONALE',     40);
define('ATT_VIS_VOLONTARI',     80);
define('ATT_VIS_PUBBLICA',      90);

$conf['att_vis'] = [
    ATT_VIS_UNITA           =>  'Unità territoriale',
    ATT_VIS_LOCALE          =>  'Comitato Locale',
    ATT_VIS_PROVINCIALE     =>  'Comitato Provinciale',
    ATT_VIS_REGIONALE       =>  'Comitato Regionale',
    ATT_VIS_VOLONTARI       =>  'Tutti i Volontari della Croce Rossa Italiana',
    ATT_VIS_PUBBLICA        =>  'Pubblica: Volontari e civili'
];


define('ATT_STATO_BOZZA',   10);
define('ATT_STATO_OK',      50);

$conf['att_stato'] = [
    ATT_STATO_BOZZA         =>  'Bozza',
    ATT_STATO_OK            =>  'Visibile'
];

/*
 * ===================================
 * =========== OBIETTIVI STRATEGICI ==
 * ===================================
 */
define('OBIETTIVO_1',   1);
define('OBIETTIVO_2',   2);
define('OBIETTIVO_3',   3);
define('OBIETTIVO_4',   4);
define('OBIETTIVO_5',   5);
define('OBIETTIVO_6',   6);

$conf['obiettivi'] = [
    OBIETTIVO_1 =>  "Obiettivo strategico 1",
    OBIETTIVO_2 =>  "Obiettivo strategico 2",
    OBIETTIVO_3 =>  "Obiettivo strategico 3",
    OBIETTIVO_4 =>  "Obiettivo strategico 4",
    OBIETTIVO_5 =>  "Obiettivo strategico 5",
    OBIETTIVO_6 =>  "Obiettivo strategico 6"
];

$conf['nomiobiettivi'] = [
    OBIETTIVO_1 =>  "Salute",
    OBIETTIVO_2 =>  "Sociale",
    OBIETTIVO_3 =>  "Emergenze",
    OBIETTIVO_4 =>  "Principi",
    OBIETTIVO_5 =>  "Giovani",
    OBIETTIVO_6 =>  "Sviluppo"
];

/*
 * ===================================
 * =========== TRAFERIMENTI ==========
 * ===================================
 */
define('TRASF_NEGATO',       10);
define('TRASF_INCORSO',      20);
define('TRASF_ANN',          25);
define('TRASF_OK',           30);
define('TRASF_AUTO',         40);

$conf['trasferimenti'] = [
    TRASF_NEGATO        =>  'Negato',
    TRASF_INCORSO       =>  'In corso',
    TRASF_ANN           =>  'Annullato',
    TRASF_OK            =>  'Con successo',
    TRASF_AUTO          =>  'Eseguito automaticamente'
];

/*
 * ===================================
 * ============ ESTENSIONI ===========
 * ===================================
 */
define('EST_CONCLUSA',      0);
define('EST_NEGATA',       10);
define('EST_INCORSO',      20);
define('EST_ANN',          25);
define('EST_OK',           30);
define('EST_AUTO',         40);


$conf['estensioni'] = [
    EST_NEGATA        =>  'Negata',
    EST_INCORSO       =>  'In attesa di autorizzazione',
    EST_ANN           =>  'Annullata',
    EST_OK            =>  'Con successo',
    EST_AUTO          =>  'Eseguita automaticamente',
    EST_CONCLUSA      =>  'Estensione conclusa'
];

/*
 * ===================================
 * =========== RISERVE ===============
 * ===================================
 */
define('RISERVA_SCAD',          0);
define('RISERVA_INT',           5);
define('RISERVA_ANN',           6);
define('RISERVA_NEGATA',       10);
define('RISERVA_INCORSO',      20);
define('RISERVA_OK',           30);
define('RISERVA_AUTO',         35);


$conf['riserve'] = [
    RISERVA_NEGATA  =>  'Negata',
    RISERVA_INCORSO =>  'In attesa di autorizzazione',
    RISERVA_ANN     =>  'Richiesta riserva annullata',
    RISERVA_OK      =>  'Riserva approvata',
    RISERVA_AUTO    =>  'Eseguita automaticamente',  
    RISERVA_SCAD    =>  'Scaduta',
    RISERVA_INT     =>  'Interrotta'
];

/*
 * ===================================
 * =========== DIMISSIONI ============
 * ===================================
 */
define('DIM_VOLONTARIE', 10);
define('DIM_TURNO',      20);
define('DIM_RISERVA',    25);
define('DIM_QUOTA',      30);
define('DIM_RADIAZIONE', 40);
define('DIM_DECEDUTO',   50);

$conf['dimissioni'] = [
    DIM_VOLONTARIE  =>  'Dimissioni Volontarie',
    DIM_TURNO       =>  'Mancato svolgimento turno',
    DIM_RISERVA     =>  'Mancato rientro da riserva',
    DIM_QUOTA       =>  'Mancato versamente quota annuale',
    DIM_RADIAZIONE  =>  'Radiazione da Croce Rossa Italiana',
    DIM_DECEDUTO    =>  'Decesso'
];

/*
 * ===================================
 * =========== GIOVANI ===============
 * ===================================
 */

define('GIOVANI', 1009821632);

/*
 * ===================================
 * =========== CENTRALE OPERATIVA ==========
 * ===================================
 */

define('CO_MONTA',       10);
define('CO_SMONTA',      20);

$conf['coturni'] = [
    CO_MONTA        =>  'In turno',
    CO_SMONTA       =>  'Smontato'
];

/*
 * ===================================
 * =========== VEICOLI ===============
 * ===================================
 */

define('VE_TRASPORTO',       10);
define('VE_OPERATIVI',      20);
define('VE_SOCCORSO',       30);

$conf['veicoli'] = [
    VE_TRASPORTO        =>  'Ciclomotore',
    VE_OPERATIVI       =>  'Motoveicolo',
    VE_SOCCORSO        =>  'Autoveicolo'
];

/*
 * ===================================
 * ====== ESTENSIONE TERRITORIALE ====
 * ===================================
 */

define('EST_UNITA',          0);
define('EST_LOCALE',        10);
define('EST_PROVINCIALE',   20);
define('EST_REGIONALE',     30);
define('EST_NAZIONALE',     40);

$conf['est_obj'] = [
    EST_UNITA       =>  'Unità',
    EST_LOCALE      =>  'Locale',
    EST_PROVINCIALE =>  'Provinciale',
    EST_REGIONALE   =>  'Regionale',
    EST_NAZIONALE   =>  'Nazionale'     
];

/*
 * ===================================
 * =========== ELEZIONI ==============
 * ===================================
 */

define('ANZIANITA', 2);

/*
 * ===================================
 * =========== TESSERAMENTO ==========
 * ===================================
 */

define('TESSERAMENTO_CHIUSO', 0);
define('TESSERAMENTO_APERTO', 10);

$conf['tesseramento'] = [
    TESSERAMENTO_CHIUSO     =>  'Chiuso',
    TESSERAMENTO_APERTO     =>  'Aperto'
];

/*
 * ===================================
 * ======== BENEMERITAZIONE ==========
 * ===================================
 */

define('BENEMERITO_NO', 0);
define('BENEMERITO_SI', 10);


/*
 * ===================================
 * =========== PIVA e CF =============
 * ===================================
 */

define('PIVA', '01019341005');
define('CF', '01906810583');

/*
 * ===================================
 * =========== APP_PATENTI ===========
 * ===================================
 */

/* Tipologia richieste patente */
define('PATENTE_RICHIESTA_PEDENTE',   10);
define('PATENTE_ATTESA_VISITA', 20);
define('PATENTE_ATTESA_STAMPA', 30);
define('PATENTE_ATTESA_CONSEGNA', 40);
define('PATENTE_CONSEGNATA', 50);

/* Definizioni in stringa */
$conf['patente'] = [
    PATENTE_RICHIESTA_PEDENTE     =>  'Rinnovo patente in corso',
    PATENTE_ATTESA_VISITA   =>  'In attesa di visita medica',
    PATENTE_ATTESA_STAMPA => 'In attesa della stampa patente',
    PATENTE_ATTESA_CONSEGNA => 'In attesa ritiro patente',
    PATENTE_CONSEGNATA => 'Patente consegnata'
];

/*
 * ===================================
 * ======= ESTENSIONE GRUPPI =========
 * ===================================
 */

define('EST_GRP_UNITA',         10);
define('EST_GRP_LOCALE',        20);
define('EST_GRP_PROVINCIALE',   30);
define('EST_GRP_REGIONALE',     40);

$conf['est_grp'] = [
    EST_GRP_UNITA       =>  'Unità',
    EST_GRP_LOCALE      =>  'Locale' ,
    EST_GRP_PROVINCIALE =>  'Provinciale',
    EST_GRP_REGIONALE   =>  'Regionale' 
];

/*
 * ===================================
 * ======= VALIDAZIONI ===============
 * ===================================
 */

define('VAL_ANNULLATA', 0);
define('VAL_CHIUSA',   10);
define('VAL_ATTESA',   15);
define('VAL_PASS',     20);
define('VAL_MAIL',     30);
define('VAL_MAILS',    40);

/*
 * ===================================
 * =========== DIZIONARI =============
 * ===================================
 */

define('DIZIONARIO_ALFANUMERICO',   10);
define('DIZIONARIO_NUMERICO',       20);
define('DIZIONARIO_ESADECIMALE',    30);
define('DIZIONARIO_BASE64',         40);

$conf['dizionario'] = [
    DIZIONARIO_ALFANUMERICO =>  '0123456789abcdefghijklmnopqrtsuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
    DIZIONARIO_NUMERICO     =>  '0123456789',
    DIZIONARIO_ESADECIMALE  =>  '0123456789abcdef',
    DIZIONARIO_BASE64       =>  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/'
];

/*
 * ===================================
 * =========== PRVACY ================
 * ===================================
 */

/* Tipologia di Privacy */
define('PRIVACY_PRIVATA',   10);
define('PRIVACY_COMITATO', 20);
define('PRIVACY_VOLONTARI', 30);
define('PRIVACY_PUBBLICA', 40);
define('PRIVACY_RISTRETTA', 50);

/*
 * ===================================
 * =========== ETA ===================
 * ===================================
 */

define('ETA_MINIMA',   14);


/*
 * ===================================
 * ============= CORSI ===============
 * ===================================
 */

define('ASPIRANTI_MINIMO_COMITATI',     5);

// Tipologia di corso. CORSO_T_<nometipo>
// Ogni tipologia di corso deve avere il proprio template
// richiesta di iscrizione in /core/conf/pdf/modelli/corso/{codice}.html

define('CORSO_T_CORSOBASE',         10);

$conf['corso_tipo'] = [
    CORSO_T_CORSOBASE       =>  'Corso base'
];


// Tipologia di accesso ai corsi. CORSO_T_<nometipo>

define('CORSO_A_POPOLAZIONE',         10);
define('CORSO_A_LAICI',               20);
define('CORSO_A_TUTTI',               30);
define('CORSO_A_VOLONTARI',           40);

$conf['corso_a'] = [
    CORSO_A_POPOLAZIONE         =>  'Corso alla popolazione',
    CORSO_A_VOLONTARI           =>  'Corso aperti ai volontari',
    CORSO_A_LAICI               =>  'Corso aperti ai non volontari',
    CORSO_A_TUTTI               =>  'Corso aperti ai volontari',
];

// Stati dei corsi. CORSO_S_<stato>

define('CORSO_S_ANNULLATO',          0);
define('CORSO_S_DACOMPLETARE',      10);
define('CORSO_S_CONCLUSO',          20);
define('CORSO_S_ATTIVO',            30);

$conf['corso_stato'] = [
    CORSO_S_ANNULLATO         =>  'Corso annullato',
    CORSO_S_DACOMPLETARE      =>  'Da completare',
    CORSO_S_CONCLUSO          =>  'Corso concluso',
    CORSO_S_ATTIVO            =>  'Corso attivo',
];

/*
 * ===================================
 * ===== PARTECIPAZIONI BASE =========
 * ===================================
 */

define('ISCR_ANNULLATA',       0);
define('ISCR_ABBANDONO',      10);
define('ISCR_RICHIESTA',      20);
define('ISCR_CONFERMATA',     30);
define('ISCR_SUPERATO',       40);
define('ISCR_BOCCIATO',       50);

$conf['partecipazioneBase'] = [
    ISCR_ANNULLATA      =>  'Annullata', 
    ISCR_ABBANDONO      =>  'Abbandonato', 
    ISCR_RICHIESTA      =>  'Preiscritto', 
    ISCR_CONFERMATA     =>  'Iscritto',
    ISCR_SUPERATO       =>  'Superato',  
    ISCR_BOCCIATO       =>  'Non superato',
];  

/*
 * ===================================
 * ============ POSTA ================
 * ===================================
 */

define('POSTA_INGRESSO',        0);
define('POSTA_USCITA',          1);
