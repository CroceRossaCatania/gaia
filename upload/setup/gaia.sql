SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `anagrafica` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `cognome` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `stato` varchar(8) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(127) CHARACTER SET latin1 DEFAULT NULL,
  `codiceFiscale` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `timestamp` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `admin` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `consenso` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `sesso` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `codiceFiscale` (`codiceFiscale`),
  KEY `email` (`email`),
  KEY `sesso` (`sesso`),
  FULLTEXT KEY `indice` (`nome`,`cognome`,`email`,`codiceFiscale`),
  FULLTEXT KEY `nome` (`nome`,`cognome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `annunci` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oggetto` varchar(255) DEFAULT NULL,
  `testo` text,
  `nPresidenti` varchar(64) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `autore` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

CREATE TABLE IF NOT EXISTS `api_chiavi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chiave` varchar(255) DEFAULT NULL,
  `oggi` int(11) DEFAULT NULL,
  `limite` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `attiva` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chiave` (`chiave`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `appartenenza` (
  `id` int(11) NOT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `comitato` varchar(16) DEFAULT NULL,
  `stato` varchar(8) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `fine` varchar(64) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `conferma` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volontario` (`volontario`),
  KEY `comitato` (`comitato`),
  KEY `stato` (`stato`),
  KEY `inizio` (`inizio`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `aree` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `comitato` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `responsabile` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `obiettivo` varchar(8) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comitato` (`comitato`),
  KEY `responsabile` (`responsabile`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `aspiranti` (
  `id` int(11) NOT NULL,
  `geo` point NOT NULL,
  `raggio` float DEFAULT NULL,
  `data` varchar(64) DEFAULT NULL,
  `utente` int(11) DEFAULT NULL,
  `luogo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `attivita` (
  `id` int(11) NOT NULL DEFAULT '0',
  `nome` varchar(255) DEFAULT '',
  `luogo` varchar(255) DEFAULT NULL,
  `comitato` varchar(32) DEFAULT NULL,
  `visibilita` int(11) DEFAULT NULL,
  `referente` varchar(32) DEFAULT NULL,
  `tipo` varchar(8) DEFAULT NULL,
  `geo` point NOT NULL,
  `descrizione` text,
  `stato` int(11) DEFAULT NULL,
  `area` int(16) DEFAULT NULL,
  `apertura` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comitato` (`comitato`),
  KEY `referente` (`referente`),
  SPATIAL KEY `geo` (`geo`),
  KEY `area` (`area`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `autoparchi` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `comitato` varchar(16) DEFAULT NULL,
  `geo` point NOT NULL,
  `pFirma` varchar(16) DEFAULT NULL,
  `tFirma` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comitato` (`comitato`),
  SPATIAL KEY `geo` (`geo`),
  FULLTEXT KEY `indice` (`comitato`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `autorizzazioni` (
  `id` int(11) NOT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `partecipazione` varchar(16) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `pFirma` varchar(16) DEFAULT NULL,
  `tFirma` varchar(64) DEFAULT NULL,
  `note` text,
  `stato` varchar(8) DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `partecipazione` (`partecipazione`),
  KEY `volontario` (`volontario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `avatar` (
  `id` int(11) NOT NULL,
  `utente` varchar(64) DEFAULT NULL,
  `timestamp` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utente` (`utente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `collocazioneVeicoli` (
  `id` int(11) NOT NULL,
  `veicolo` varchar(16) DEFAULT NULL,
  `autoparco` varchar(16) DEFAULT NULL,
  `pConferma` varchar(16) DEFAULT NULL,
  `tConferma` varchar(64) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `fine` varchar(64) DEFAULT NULL,
  `pFine` varchar(16) DEFAULT NULL,
  `tFine` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `veicolo` (`veicolo`),
  KEY `autoparco` (`autoparco`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `comitati` (
  `id` int(11) NOT NULL,
  `nome` varchar(64) DEFAULT NULL,
  `colore` varchar(8) DEFAULT NULL,
  `locale` int(11) DEFAULT NULL,
  `geo` point NOT NULL,
  `principale` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  SPATIAL KEY `geo` (`geo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `commenti` (
  `id` int(11) NOT NULL,
  `attivita` varchar(16) DEFAULT NULL,
  `commento` varchar(255) DEFAULT NULL,
  `volontario` varchar(64) DEFAULT NULL,
  `tCommenta` varchar(16) DEFAULT NULL,
  `upCommento` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volontario` (`volontario`),
  KEY `attivita` (`attivita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `corsibase` (
  `id` int(11) NOT NULL,
  `luogo` varchar(255) DEFAULT NULL,
  `organizzatore` varchar(32) DEFAULT NULL,
  `direttore` varchar(32) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `progressivo` varchar(64) DEFAULT NULL,
  `anno` VARCHAR(8) NULL DEFAULT NULL,
  `geo` point NOT NULL,
  `descrizione` text,
  `stato` int(11) DEFAULT NULL,
  `aggiornamento` varchar(64) DEFAULT NULL,
  `tEsame` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `organizzatore` (`organizzatore`),
  KEY `direttore` (`direttore`),
  SPATIAL KEY `geo` (`geo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `coturni` (
  `id` int(11) NOT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `appartenenza` varchar(16) DEFAULT NULL,
  `turno` varchar(16) DEFAULT NULL,
  `stato` varchar(64) DEFAULT NULL,
  `pMonta` varchar(16) DEFAULT NULL,
  `tMonta` varchar(64) DEFAULT NULL,
  `pSmonta` varchar(16) DEFAULT NULL,
  `tSmonta` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comitato` (`appartenenza`),
  KEY `volontario` (`volontario`),
  KEY `turno` (`turno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `datiComitati` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `datiPartecipazioniBase` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `datiLocali` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `datiNazionali` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `datiProvinciali` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `datiRegionali` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `datiSessione` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `delegati` (
  `id` int(11) NOT NULL,
  `comitato` varchar(16) DEFAULT NULL,
  `estensione` varchar(5) DEFAULT '0',
  `volontario` varchar(16) DEFAULT NULL,
  `applicazione` varchar(16) DEFAULT NULL,
  `dominio` varchar(16) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `fine` varchar(64) DEFAULT NULL,
  `pConferma` varchar(16) DEFAULT NULL,
  `tConferma` varchar(64) DEFAULT NULL,
  `partecipazione` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comitato` (`comitato`),
  KEY `applicazione` (`applicazione`),
  KEY `volontario` (`volontario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `dettagliAttivita` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `dettagliAutoparco` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `dettagliComitato` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `dettagliCorsibase` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `dettagliPersona` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`),
  KEY `id` (`id`),
  KEY `nome` (`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `dettagliVeicolo` (
  `id` varchar(128) NOT NULL DEFAULT '',
  `nome` varchar(32) NOT NULL DEFAULT '',
  `valore` text,
  PRIMARY KEY (`id`,`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `dimissioni` (
  `id` int(11) NOT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `appartenenza` varchar(16) DEFAULT NULL,
  `comitato` varchar(16) DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `tConferma` varchar(64) DEFAULT NULL,
  `pConferma` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volontario` (`volontario`),
  KEY `comitato` (`comitato`),
  KEY `appartenenza` (`appartenenza`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `documenti` (
  `id` varchar(64) NOT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `tipo` varchar(8) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volontario` (`volontario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `elementiRichieste` (
  `id` int(11) NOT NULL,
  `richiesta` int(11) NOT NULL,
  `titolo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `estensioni` (
  `id` int(11) NOT NULL,
  `stato` varchar(16) DEFAULT NULL,
  `appartenenza` varchar(16) DEFAULT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `cProvenienza` varchar(16) DEFAULT NULL,
  `protNumero` varchar(16) DEFAULT NULL,
  `protData` varchar(64) DEFAULT NULL,
  `motivo` text,
  `negazione` text,
  `timestamp` varchar(64) DEFAULT NULL,
  `pConferma` varchar(16) DEFAULT NULL,
  `tConferma` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appartenenza` (`appartenenza`),
  KEY `volontario` (`volontario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `fermotecnico` (
  `id` int(11) NOT NULL,
  `veicolo` varchar(16) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `fine` varchar(64) DEFAULT NULL,
  `motivo` text,
  `pInizio` varchar(16) DEFAULT NULL,
  `tInizio` varchar(64) DEFAULT NULL,
  `pFine` varchar(16) DEFAULT NULL,
  `tFine` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `veicolo` (`veicolo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `file` (
  `id` varchar(64) NOT NULL,
  `creazione` varchar(64) DEFAULT NULL,
  `autore` varchar(16) DEFAULT NULL,
  `scadenza` varchar(64) DEFAULT NULL,
  `mime` varchar(64) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `download` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scadenza` (`scadenza`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `fototessera` (
  `id` int(11) NOT NULL,
  `utente` varchar(64) DEFAULT NULL,
  `timestamp` varchar(8) DEFAULT NULL,
  `stato` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utente` (`utente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `gruppi` (
  `id` int(11) NOT NULL,
  `comitato` varchar(16) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `obiettivo` varchar(8) DEFAULT NULL,
  `area` varchar(16) DEFAULT NULL,
  `referente` varchar(16) DEFAULT NULL,
  `attivita` varchar(16) DEFAULT NULL,
  `estensione` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comitato` (`comitato`),
  KEY `referente` (`referente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `gruppiPersonali` (
  `id` int(11) NOT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `comitato` varchar(16) DEFAULT NULL,
  `gruppo` varchar(16) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `fine` varchar(64) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `motivazione` varchar(255) DEFAULT NULL,
  `tNega` varchar(64) DEFAULT NULL,
  `pNega` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volontario` (`volontario`),
  KEY `comitato` (`comitato`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `lezioni` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `inizio` int(11) DEFAULT NULL,
  `fine` int(11) DEFAULT NULL,
  `corso` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inizio` (`inizio`),
  KEY `corso` (`corso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `lezioni_assenze` (
  `id` int(11) NOT NULL,
  `lezione` int(11) DEFAULT NULL,
  `utente` int(11) DEFAULT NULL,
  `pConferma` int(11) DEFAULT NULL,
  `tConferma` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lezione` (`lezione`,`utente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `locali` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `geo` point NOT NULL,
  `provinciale` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provinciale` (`provinciale`),
  SPATIAL KEY `geo` (`geo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `manutenzioni` (
  `id` int(11) NOT NULL,
  `veicolo` varchar(16) DEFAULT NULL,
  `intervento` text,
  `tIntervento` varchar(16) DEFAULT NULL,
  `tRegistra` varchar(64) DEFAULT NULL,
  `pRegistra` varchar(16) DEFAULT NULL,
  `km` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `costo` varchar(64) DEFAULT NULL,
  `fattura` varchar(255) DEFAULT NULL,
  `azienda` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `veicolo` (`veicolo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mipiace` (
  `id` int(11) NOT NULL,
  `oggetto` varchar(16) DEFAULT NULL,
  `volontario` int(11) DEFAULT NULL,
  `timestamp` int(16) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volontario` (`volontario`),
  KEY `oggetto` (`oggetto`),
  KEY `cercatipo` (`volontario`, `oggetto`),
  KEY `cercalike` (`tipo`, `oggetto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `nazionali` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `geo` point NOT NULL,
  PRIMARY KEY (`id`),
  SPATIAL KEY `geo` (`geo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `partecipazioni` (
  `id` int(11) NOT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `turno` varchar(16) DEFAULT NULL,
  `stato` varchar(8) DEFAULT NULL,
  `tipo` varchar(8) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `tConferma` varchar(64) DEFAULT NULL,
  `pConferma` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `turno` (`turno`),
  KEY `volontario` (`volontario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `partecipazioniBase` (
  `id` int(11) NOT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `corsoBase` varchar(16) DEFAULT NULL,
  `stato` varchar(8) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `tConferma` varchar(64) DEFAULT NULL,
  `pConferma` varchar(16) DEFAULT NULL,
  `tAttestato` varchar(64) DEFAULT NULL,
  `cAttestato` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `corsoBase` (`corsoBase`),
  KEY `volontario` (`volontario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `privacy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `volontario` varchar(16) DEFAULT NULL,
  `contatti` int(1) DEFAULT NULL,
  `mess` int(1) DEFAULT NULL,
  `curriculum` int(1) DEFAULT NULL,
  `incarichi` int(1) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volontario` (`volontario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17420 ;

CREATE TABLE IF NOT EXISTS `provinciali` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `geo` point NOT NULL,
  `regionale` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `regionale` (`regionale`),
  SPATIAL KEY `geo` (`geo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `quote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appartenenza` varchar(16) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `tConferma` varchar(64) DEFAULT NULL,
  `pConferma` varchar(16) DEFAULT NULL,
  `quota` varchar(255) DEFAULT NULL,
  `offerta` varchar(255) DEFAULT NULL,
  `causale` varchar(255) DEFAULT NULL,
  `anno` varchar(4) DEFAULT NULL,
  `pAnnullata` varchar(16) DEFAULT NULL,
  `tAnnullata` varchar(16) DEFAULT NULL,
  `progressivo` int(8) DEFAULT NULL,
  `benemerito` int(8) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appartenenza` (`appartenenza`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7894 ;

CREATE TABLE IF NOT EXISTS `regionali` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `geo` point NOT NULL,
  `nazionale` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nazionale` (`nazionale`),
  SPATIAL KEY `geo` (`geo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `reperibilita` (
  `id` int(11) NOT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `comitato` varchar(16) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `fine` varchar(64) DEFAULT NULL,
  `attivazione` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comitato` (`comitato`),
  KEY `volontario` (`volontario`),
  KEY `inizio` (`inizio`),
  KEY `fine` (`fine`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `richiesteTurni` (
  `id` int(11) NOT NULL,
  `turno` int(11) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `rifornimento` (
  `id` int(11) NOT NULL,
  `pRegistra` varchar(16) DEFAULT NULL,
  `tRegistra` varchar(64) DEFAULT NULL,
  `km` varchar(255) DEFAULT NULL,
  `data` varchar(64) DEFAULT NULL,
  `veicolo` varchar(16) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `litri` varchar(64) DEFAULT NULL,
  `costo` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `veicolo` (`veicolo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `riserve` (
  `id` int(11) NOT NULL,
  `stato` varchar(16) DEFAULT NULL,
  `appartenenza` varchar(16) DEFAULT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `fine` varchar(64) DEFAULT NULL,
  `protNumero` varchar(16) DEFAULT NULL,
  `protData` varchar(64) DEFAULT NULL,
  `motivo` text,
  `negazione` text,
  `timestamp` varchar(64) DEFAULT NULL,
  `pConferma` varchar(16) DEFAULT NULL,
  `tConferma` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appartenenza` (`appartenenza`),
  KEY `volontario` (`volontario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sessioni` (
  `id` varchar(128) NOT NULL,
  `utente` int(11) DEFAULT NULL,
  `azione` varchar(64) DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `agent` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `tesseramenti` (
  `id` int(11) NOT NULL,
  `stato` int(11) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `fine` varchar(64) DEFAULT NULL,
  `anno` varchar(16) DEFAULT NULL,
  `attivo` varchar(10) DEFAULT NULL,
  `ordinario` varchar(10) DEFAULT NULL,
  `benemerito` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tesserinoRichiesta` (
  `id` int(11) NOT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `stato` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `codice` varchar(64) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `pRichiesta` varchar(16) DEFAULT NULL,
  `tRichiesta` varchar(64) DEFAULT NULL,
  `pConferma` varchar(16) DEFAULT NULL,
  `tConferma` varchar(64) DEFAULT NULL,
  `motivo` text,
  `struttura` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volontario` (`volontario`),
  KEY `struttura` (`struttura`),
  KEY `codice` (`codice`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `titoli` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `tipo` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `nome` (`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `titoliPersonali` (
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

CREATE TABLE IF NOT EXISTS `trasferimenti` (
  `id` int(11) NOT NULL,
  `stato` varchar(16) DEFAULT NULL,
  `appartenenza` varchar(16) DEFAULT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `protNumero` varchar(16) DEFAULT NULL,
  `protData` varchar(64) DEFAULT NULL,
  `motivo` text,
  `negazione` text,
  `timestamp` varchar(64) DEFAULT NULL,
  `pConferma` varchar(16) DEFAULT NULL,
  `tConferma` varchar(64) DEFAULT NULL,
  `cProvenienza` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appartenenza` (`appartenenza`),
  KEY `volontario` (`volontario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `turni` (
  `id` int(11) NOT NULL,
  `attivita` varchar(16) DEFAULT NULL,
  `nome` varchar(64) DEFAULT NULL,
  `inizio` varchar(64) DEFAULT NULL,
  `fine` varchar(64) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `minimo` varchar(8) DEFAULT NULL,
  `massimo` varchar(8) DEFAULT NULL,
  `prenotazione` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attivita` (`attivita`),
  KEY `inizio` (`inizio`),
  KEY `fine` (`fine`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `validazioni` (
  `id` int(11) NOT NULL DEFAULT '0',
  `codice` varchar(127) DEFAULT NULL,
  `stato` varchar(8) DEFAULT NULL,
  `volontario` varchar(16) DEFAULT NULL,
  `timestamp` varchar(64) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `codice` (`codice`,`stato`,`volontario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `veicoli` (
  `id` int(11) NOT NULL,
  `targa` varchar(255) DEFAULT NULL,
  `libretto` varchar(255) DEFAULT NULL,
  `telaio` varchar(255) DEFAULT NULL,
  `comitato` varchar(16) DEFAULT NULL,
  `stato` varchar(8) DEFAULT NULL,
  `pFuoriuso` varchar(16) DEFAULT NULL,
  `tFuoriuso` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `targa` (`targa`),
  KEY `libretto` (`libretto`),
  KEY `telaio` (`telaio`),
  KEY `comitato` (`comitato`),
  KEY `stato` (`stato`),
  FULLTEXT KEY `indice` (`libretto`,`targa`,`comitato`,`stato`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
