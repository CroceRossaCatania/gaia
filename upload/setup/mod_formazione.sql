--
-- Table structure for table `crs_corsi`
--
DROP TABLE IF EXISTS `crs_corsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crs_corsi` (
  `id` int(11) NOT NULL,
  `tipo` int(11) DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `organizzatore` varchar(32) DEFAULT NULL,
  `responsabile` int(11) DEFAULT NULL,
  `direttore` int(11) DEFAULT NULL,
  `inizio` int(11) DEFAULT NULL,
  `progressivo` int(11) DEFAULT NULL,
  `partecipanti` int(11) DEFAULT NULL,
  `luogo` varchar(255) DEFAULT NULL,
  `anno` varchar(8) DEFAULT NULL,
  `geo` point NOT NULL,
  `descrizione` text,
  `iscritti` int(11) DEFAULT NULL,
  `stato` int(11) DEFAULT NULL,
  `aggiornamento` int(11) DEFAULT NULL,
  `tEsame` int(11) DEFAULT NULL,
  `provincia` varchar(64) DEFAULT NULL,
  `seriale` varchar(45) DEFAULT NULL,
  `verbale` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `seriale_UNIQUE` (`seriale`),
  KEY `organizzatore` (`organizzatore`),
  KEY `direttore` (`direttore`),
  SPATIAL KEY `geo` (`geo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_dettagliCorsi`
--

DROP TABLE IF EXISTS `crs_dettagliCorsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crs_dettagliCorsi` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_giornataCorso`
--

DROP TABLE IF EXISTS `crs_giornataCorso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crs_giornataCorso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `corso` int(11) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `luogo` varchar(255) DEFAULT NULL,
  `data` int(11) DEFAULT NULL,
  `note` mediumtext,
  PRIMARY KEY (`id`),
  KEY `idx_corso` (`corso`)
) ENGINE=InnoDB AUTO_INCREMENT=515 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_partecipazioni_corsi`
--

DROP TABLE IF EXISTS `crs_partecipazioni_corsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crs_partecipazioni_corsi` (
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
  `md5` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `corso` (`corso`),
  KEY `volontario` (`volontario`)
) ENGINE=MyISAM AUTO_INCREMENT=150 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_qualifiche`
--

DROP TABLE IF EXISTS `crs_qualifiche`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crs_qualifiche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `vecchiaNomenclatura` varchar(255) DEFAULT NULL,
  `area` int(2) DEFAULT NULL,
  `attiva` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_risultati_corsi`
--

DROP TABLE IF EXISTS `crs_risultati_corsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crs_risultati_corsi` (
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
  `seriale` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `mixed_UNIQUE` (`volontario`,`corso`,`timestamp`),
  UNIQUE KEY `file_UNIQUE` (`file`),
  UNIQUE KEY `seriale_UNIQUE` (`seriale`),
  KEY `corso` (`corso`),
  KEY `volontario` (`volontario`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_ruoli`
--

DROP TABLE IF EXISTS `crs_ruoli`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crs_ruoli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruolo` varchar(45) DEFAULT NULL,
  `requisito` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_tipoCorsi`
--

DROP TABLE IF EXISTS `crs_tipoCorsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crs_tipoCorsi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `ruoloDirettore` int(11) DEFAULT NULL,
  `ruoloDocenti` int(11) DEFAULT NULL,
  `ruoloAffiancamento` int(11) DEFAULT NULL,
  `ruoloDiscenti` int(11) DEFAULT NULL,
  `ruoloAttestato` int(11) DEFAULT NULL,
  `limitePerIscrizione` int(11) DEFAULT NULL COMMENT 'In giorni',
  `proporzioneIstruttori` int(11) DEFAULT NULL COMMENT 'Quanti Docenti in affiancemento per docente 1/valore',
  `minimoPartecipanti` int(11) DEFAULT NULL,
  `massimoPartecipanti` int(11) DEFAULT NULL,
  `proporzioneAffiancamento` int(11) DEFAULT NULL COMMENT '1/valore',
  `durata` int(11) DEFAULT NULL,
  `giorni` int(11) DEFAULT NULL,
  `punizione` int(11) DEFAULT NULL,
  `dipendenzaAffiancamento` int(11) DEFAULT NULL COMMENT 'ID del corso che un volontario deve aver superato per poter fare affiancamento qui',
  `abilitaNazionale` int(1) DEFAULT '0' COMMENT 'il nazionale può creare questo tipo di corso',
  `abilitaRegionale` int(1) DEFAULT '0' COMMENT 'il regionale può creare questo tipo di corso',
  `abilitaProvinciale` int(1) DEFAULT '0' COMMENT 'il provinciale può creare questo tipo di corso',
  `abilitaLocale` int(1) DEFAULT '0',
  `qualifica` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crs_titoliCorsi`
--

DROP TABLE IF EXISTS `crs_titoliCorsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crs_titoliCorsi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;







-- ------------------------------------------------------------------------------------
-- Funzione per generare il seriale per anno e per corso di un certificato
-- ------------------------------------------------------------------------------------
DROP FUNCTION IF EXISTS generaSerialeCertificato;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `generaSerialeCertificato`(yyyy INT, tipocorsoId INT) RETURNS varchar(30) CHARSET latin1
BEGIN
  DECLARE lastSerial INT;
  DECLARE newSerial INT;
  DECLARE paddingSizeSerial INT;
  DECLARE paddingSizeCorsoId INT;
  
  SET paddingSizeSerial = 8;
  SET paddingSizeCorsoId = 3;
    
  SELECT max(right(crc.seriale, paddingSizeSerial)) AS tmp INTO lastSerial 
	FROM crs_risultati_corsi crc JOIN crs_corsi cc ON cc.id = crc.corso
	WHERE year(from_unixtime(crc.timestamp)) = yyyy AND cc.certificato = tipocorsoId;
  
  IF lastSerial is null THEN 
	SET newSerial = 0;
  ELSE 
	SET newSerial = lastSerial;
  END IF;
    
  RETURN CONCAT(yyyy,"-",LPAD(tipocorsoId, paddingSizeCorsoId ,'0'),"-",LPAD(newSerial+1, paddingSizeSerial, '0'));
END
$$

-- ------------------------------------------------------------------------------------
-- Funzione per generare il seriale per anno e di un corso
-- ------------------------------------------------------------------------------------
DROP FUNCTION IF EXISTS generaSerialeCorso;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `generaSerialeCorso`(yyyy INT, tipocorsoId INT) RETURNS varchar(30) CHARSET latin1
BEGIN
  DECLARE lastSerial INT;
  DECLARE newSerial INT;
  DECLARE paddingSizeSerial INT;
  DECLARE paddingSizeCorsoId INT;
  
  SET paddingSizeSerial = 8;
  SET paddingSizeCorsoId = 3;
  
  SELECT max(right(seriale, paddingSizeSerial)) AS tmp INTO lastSerial FROM crs_corsi 
	WHERE year(from_unixtime(inizio)) = yyyy AND certificato = tipocorsoId;
  
  IF lastSerial is null THEN 
	SET newSerial = 0;
  ELSE 
	SET newSerial = lastSerial;
  END IF;
    
  RETURN CONCAT(yyyy,"-",LPAD(tipocorsoId, paddingSizeCorsoId ,'0'),"-",LPAD(newSerial+1, paddingSizeSerial, '0'));
END
$$



/* 
Da creare insert per inserire in dettagliPersona, ps = on per tutti quelli che hanno
una laurea in medicina o infermieristica
*/