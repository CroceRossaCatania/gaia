CREATE TABLE IF NOT EXISTS `crs_corsi` (
  `id` int(11) NOT NULL,
  `certificato` int(11) DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `organizzatore` varchar(32) DEFAULT NULL,
  `responsabile` int(11) DEFAULT NULL,
  `direttore` int(11) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `progressivo` int(11) DEFAULT NULL,
  `partecipanti` int(11) DEFAULT NULL,
  `luogo` varchar(255) DEFAULT NULL,
  `anno` varchar(8) DEFAULT NULL,
  `geo` point NOT NULL,
  `descrizione` text,
  `iscritti` int(11) DEFAULT NULL,
  `stato` int(11) DEFAULT NULL,
  `aggiornamento` varchar(64) DEFAULT NULL,
  `tEsame` varchar(64) DEFAULT NULL,
  `provincia` varchar(64) DEFAULT NULL,
  `insegnanti` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `organizzatore` (`organizzatore`),
  KEY `direttore` (`direttore`),
  SPATIAL KEY `geo` (`geo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `crs_dettagliCorsi` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/**
* Da rimuovere
*/
CREATE TABLE IF NOT EXISTS `crs_iscrizioni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `corso` int(11) DEFAULT NULL,
  `anagrafica` int(11) DEFAULT NULL,
  `ruolo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `crs_partecipazioni_corsi` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `volontario` varchar(16) DEFAULT NULL,
  `corso` varchar(16) DEFAULT NULL,
  `ruolo` int(11) DEFAULT NULL,
  `stato` varchar(8) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `tConferma` varchar(64) DEFAULT NULL,
  `pConferma` varchar(16) DEFAULT NULL,
  `tAttestato` varchar(64) DEFAULT NULL,
  `cAttestato` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `corso` (`corso`),
  KEY `volontario` (`volontario`) KEY `volontario` (`volontario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `crs_tipoCorsi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `ruoloProprietario` varchar(255) DEFAULT NULL,
  `ruoloDirettore` varchar(255) DEFAULT NULL,
  `ruoloDocenti` varchar(255) DEFAULT NULL,
  `ruoloAffiancamento` varchar(255) DEFAULT NULL,
  `ruoloDiscenti` varchar(255) DEFAULT NULL,
  `tipoValutazione` varchar(255) DEFAULT NULL,
  `attestato` varchar(255) DEFAULT NULL COMMENT 'Il template del documento, se passato con sucesso',
  `limitePerIscrizione` int(11) DEFAULT NULL COMMENT 'In giorni',
  `proporzioneIstruttori` int(11) DEFAULT NULL COMMENT 'Quanti Docenti in affiancemento per docente 1/valore',
  `minimoPartecipanti` int(11) DEFAULT NULL,
  `massimoPartecipanti` int(11) DEFAULT NULL,
  `proporzioneAffiancamento` int(11) DEFAULT NULL COMMENT '1/valore',
  `durata` int(11) DEFAULT NULL,
  `giorni` int(11) DEFAULT NULL,
  `punizione` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `crs_risultati_corsi` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `volontario` int(11) DEFAULT NULL,
  `corso` int(11) DEFAULT NULL,
  `idoneita` int(11) DEFAULT NULL,
  `segnalazione` int(11) DEFAULT NULL COMMENT 'numero di segnalatori',
  `segnalatori` varchar(64) DEFAULT NULL COMMENT 'id dei segnalatori',
  `timestamp` varchar(64) DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `mixed_UNIQUE` (`volontario`,`corso`,`timestamp`),
  KEY `corso` (`corso`),
  KEY `volontario` (`volontario`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `crs_titoliCorsi` (
  `id` int(11) NOT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `titolo` varchar(16) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `fine` varchar(64) DEFAULT NULL,
  `luogo` varchar(64) DEFAULT NULL,
  `codice` varchar(64) DEFAULT NULL,
  `tConferma` varchar(64) DEFAULT NULL,
  `pConferma` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


ALTER TABLE `corsi` RENAME TO  `crs_corsi`;
ALTER TABLE `dettagliCorsi` RENAME TO  `crs_dettagliCorsi`;
ALTER TABLE `iscrizioni` RENAME TO `crs_iscrizioni`;
ALTER TABLE `partecipazioni_corsi` RENAME TO  `crs_partecipazioni_corsi`;
ALTER TABLE `tipoCorsi` RENAME TO `crs_tipoCorsi`;
ALTER TABLE `risultati_corsi` RENAME TO  `crs_risultati_corsi`;


ALTER TABLE `gaia`.`risultati_corsi` 
DROP COLUMN `segnalatori`,
CHANGE COLUMN `segnalazione` `segnalazione_01` INT(11) NULL DEFAULT NULL COMMENT 'numero di segnalatori' ,
ADD COLUMN `segnalazione_02` INT NULL DEFAULT NULL COMMENT '' AFTER `segnalazione_01`,
ADD COLUMN `segnalazione_03` INT NULL DEFAULT NULL COMMENT '' AFTER `segnalazione_02`;

INSERT INTO crs_titoliCorsi SELECT * FROM titoliPersonali;

ALTER TABLE `crs_tipoCorsi` 
CHANGE COLUMN `crs_tipoCorsicol` `dipendenzaAffiancamento` INT NULL DEFAULT NULL COMMENT 'ID del corso che un volontario deve aver superato per poter fare affiancamento qui' ;

ALTER TABLE `crs_titoliCorsi` 
ADD INDEX `idx_volontario` (`volontario` ASC)  COMMENT '';

ALTER TABLE `crs_risultati_corsi` 
ADD COLUMN `file` VARCHAR(64) NULL DEFAULT NULL AFTER `note`,
ADD COLUMN `generato` INT(1) NOT NULL DEFAULT 0 AFTER `file`;
ALTER TABLE `crs_risultati_corsi` 
ADD UNIQUE INDEX `file_UNIQUE` (`file` ASC);
ALTER TABLE `crs_risultati_corsi` 
ADD COLUMN `serial` VARCHAR(16) NULL DEFAULT NULL AFTER `generato`,

ALTER TABLE `crs_risultati_corsi` 
CHANGE COLUMN `serial` `serial` INT UNSIGNED NULL DEFAULT NULL ;
ADD UNIQUE INDEX `serial_UNIQUE` (`serial` ASC);

DROP FUNCTION IF EXISTS generaSeriale;
DELIMITER $$
CREATE FUNCTION generaSeriale(yyyy INT)
  RETURNS INT
BEGIN
  DECLARE lastSerial INT;
  DECLARE newSerial INT;
  
  SELECT serial INTO lastSerial FROM crs_risultati_corsi 
	WHERE year(from_unixtime(timestamp)) = yyyy;
  
  IF lastSerial is null THEN 
	SET newSerial = 0;
  ELSE 
	SET newSerial = lastSerial+1;
  END IF;
    
  RETURN newSerial;
END;
$$
