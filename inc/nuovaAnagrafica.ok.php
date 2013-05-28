<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/*
 * Normalizzazione dei dati
 */
$id         = $_POST['id'];
$nome       = normalizzaNome($_POST['inputNome']);
$cognome    = normalizzaNome($_POST['inputCognome']);
$dnascita   = mktime(0, 0, 0, $_POST['inputMese'], $_POST['inputGiorno'], $_POST['inputAnno']);
$prnascita= maiuscolo($_POST['inputProvinciaNascita']);
$conascita = normalizzaNome($_POST['inputComuneNascita']);
$coresidenza= normalizzaNome($_POST['inputComuneResidenza']);
$caresidenza= normalizzaNome($_POST['inputCAPResidenza']);
$prresidenza= maiuscolo($_POST['inputProvinciaResidenza']);
$indirizzo  = normalizzaNome($_POST['inputIndirizzo']);
$civico     = maiuscolo($_POST['inputCivico']);
$grsanguigno = maiuscolo($_POST['inputgruppoSanguigno']);
$consenso = $_POST['inputConsenso'];
/*
 * Controlla esistenza varia e ti porta dove dovrebbe 
 */
$p = new Persona($id);
if ( ($p->password) ) { 
    redirect('giaRegistrato');
}

/*
 * Registrazione vera e propria...
 */
$p->nome                = $nome;
$p->cognome             = $cognome;
$p->dataNascita         = $dnascita;
$p->provinciaNascita =$prnascita;
$p->comuneNascita = $conascita;
$p->comuneResidenza     = $coresidenza;
$p->CAPResidenza        = $caresidenza;
$p->provinciaResidenza  = $prresidenza;
$p->indirizzo 		= $indirizzo;
$p->civico   		= $civico;
$p->grsanguigno   		= $grsanguigno;
$p->timestamp           = time();
$p->stato               = PERSONA;
$p->consenso = $consenso;

/*
 * Associa la sessione all'utente...
 */
$sessione->utente = $p->id;


/*
 * Continuiamo la registrazione...
 */
redirect('nuovaAnagraficaContatti');