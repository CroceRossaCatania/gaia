
--
-- Table structure for table `crs_corsi`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  PRIMARY KEY (`id`),
  KEY `organizzatore` (`organizzatore`),
  KEY `direttore` (`direttore`),
  SPATIAL KEY `geo` (`geo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_dettagliCorsi`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `crs_dettagliCorsi` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_iscrizioni`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `crs_iscrizioni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `corso` int(11) DEFAULT NULL,
  `anagrafica` int(11) DEFAULT NULL,
  `ruolo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_partecipazioni_corsi`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  KEY `volontario` (`volontario`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_risultati_corsi`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `crs_risultati_corsi` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `volontario` int(11) DEFAULT NULL,
  `corso` int(11) DEFAULT NULL,
  `idoneita` int(11) DEFAULT NULL,
  `segnalazione_01` int(11) DEFAULT NULL COMMENT 'numero di segnalatori',
  `segnalazione_02` int(11) DEFAULT NULL,
  `segnalazione_03` int(11) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `note` text,
  `file` varchar(64) DEFAULT NULL,
  `generato` int(1) NOT NULL DEFAULT '0',
  `seriale` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `mixed_UNIQUE` (`volontario`,`corso`,`timestamp`),
  UNIQUE KEY `file_UNIQUE` (`file`),
  KEY `corso` (`corso`),
  KEY `volontario` (`volontario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_tipoCorsi`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `dipendenzaAffiancamento` int(11) DEFAULT NULL COMMENT 'ID del corso che un volontario deve aver superato per poter fare affiancamento qui',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_titoliCorsi`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `crs_titoliCorsi` (
  `id` int(11) NOT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `titolo` varchar(16) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `fine` varchar(64) DEFAULT NULL,
  `luogo` varchar(64) DEFAULT NULL,
  `codice` varchar(64) DEFAULT NULL,
  `tConferma` varchar(64) DEFAULT NULL,
  `pConferma` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_volontario` (`volontario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP FUNCTION IF EXISTS generaSeriale;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `generaSeriale`(yyyy INT) RETURNS varchar(30) CHARSET latin1
BEGIN
  DECLARE lastSerial INT;
  DECLARE newSerial INT;
  DECLARE paddingSize INT;
  
  SET paddingSize = 8;
  
  SELECT max(right(seriale, paddingSize)) AS tmp INTO lastSerial FROM crs_risultati_corsi WHERE year(from_unixtime(timestamp)) = yyyy;
  
  IF lastSerial is null THEN 
	SET newSerial = 0;
  ELSE 
	SET newSerial = lastSerial;
  END IF;
    
  RETURN CONCAT(yyyy,"-",LPAD(newSerial+1, paddingSize, '0'));
END
$$
