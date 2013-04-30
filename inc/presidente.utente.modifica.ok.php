<?php

/*
 * ©2013 Croce Rossa Italiana
 */


/*
 * Normalizzazione dei dati
 */
$id         = $_GET['t'];
$nome       = normalizzaNome($_POST['inputNome']);
$cognome    = normalizzaNome($_POST['inputCognome']);
$codiceFiscale = maiuscolo($_POST['inputCodiceFiscale']);
$dnascita = DT::createFromFormat('d/m/Y', $_POST['inputDataNascita']);
$dnascita = $dnascita->getTimestamp();
$prnascita= maiuscolo($_POST['inputProvinciaNascita']);
$conascita = normalizzaNome($_POST['inputComuneNascita']);
$coresidenza= normalizzaNome($_POST['inputComuneResidenza']);
$caresidenza= normalizzaNome($_POST['inputCAPResidenza']);
$prresidenza= maiuscolo($_POST['inputProvinciaResidenza']);
$indirizzo  = normalizzaNome($_POST['inputIndirizzo']);
$civico     = maiuscolo($_POST['inputCivico']);
$email      = minuscolo($_POST['inputEmail']);
$cell       = normalizzaNome($_POST['inputCellulare']);
$cells      = normalizzaNome(@$_POST['inputCellulareServizio']);
$grsanguigno = $_POST['inputgruppoSanguigno'];
/*
 * Controlla esistenza varia e ti porta dove dovrebbe 
 */
$p = new Persona($id);

/*
 * Registrazione vera e propria...
 */
$p->nome                = $nome;
$p->cognome             = $cognome;
$p->codiceFiscale = $codiceFiscale;
$p->dataNascita         = $dnascita;
$p->provinciaNascita =$prnascita;
$p->comuneNascita = $conascita;
$p->comuneResidenza     = $coresidenza;
$p->CAPResidenza        = $caresidenza;
$p->provinciaResidenza  = $prresidenza;
$p->indirizzo 		= $indirizzo;
$p->civico   		= $civico;
$p->email               = $email;
$p->cellulare           = $cell;
$p->cellulareServizio   = $cells;
$p->grsanguigno   		= $grsanguigno;
$p->timestamp           = time();
$p->stato               = VOLONTARIO;

redirect('presidente.utente.visualizza&ok&id='.$_GET['t']);