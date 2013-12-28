<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/*
 * Normalizzazione dei dati
 */

$parametri = array('id', 'inputNome', 'inputCognome', 'inputDataNascita', 
	'inputProvinciaNascita', 'inputComuneNascita', 'inputComuneResidenza', 'inputCAPResidenza',
	'inputProvinciaResidenza', 'inputIndirizzo', 'inputCivico');
controllaParametri($parametri, 'nuovaAnagrafica&err');

$id         = $_POST['id'];
$nome       = normalizzaNome($_POST['inputNome']);
$cognome    = normalizzaNome($_POST['inputCognome']);
$sesso 		= $_POST['inputSesso'];
$dnascita   = DT::createFromFormat('d/m/Y', $_POST['inputDataNascita']);
$prnascita 	= maiuscolo($_POST['inputProvinciaNascita']);
$conascita 	= normalizzaNome($_POST['inputComuneNascita']);
$coresidenza= normalizzaNome($_POST['inputComuneResidenza']);
$caresidenza= normalizzaNome($_POST['inputCAPResidenza']);
$prresidenza= maiuscolo($_POST['inputProvinciaResidenza']);
$indirizzo  = normalizzaNome($_POST['inputIndirizzo']);
$civico     = maiuscolo($_POST['inputCivico']);

/*
 * Scrive i dati nella sessione 
 */
$sessione->nome 		= $nome;
$sessione->cognome 		= $cognome;
$sessione->sesso 		= $sesso;
$sessione->dnascita 	= $_POST['inputDataNascita'];
$sessione->prnascita 	= $prnascita;
$sessione->conascita 	= $conascita;
$sessione->coresidenza  = $coresidenza;
$sessione->caresidenza  = $caresidenza;
$sessione->prresidenza  = $prresidenza;
$sessione->indirizzo 	= $indirizzo;
$sessione->civico 		= $civico;

/*
 * Esegue i check sui dati
 */
if(!DT::controlloData($_POST['inputDataNascita'])){
	redirect('nuovaAnagrafica&data');
}

/*
 * Verifica se ho più di 14 anni
 */
$quattordiciAnniFa = time() - ETAMINIMA;
if($dnascita->getTimestamp() > $quattordiciAnniFa){
	redirect('nuovaAnagrafica&eta');
}
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
$p->sesso 				= ($sesso) ? UOMO : DONNA;
$p->dataNascita         = $dnascita->getTimestamp();;
$p->provinciaNascita 	= $prnascita;
$p->comuneNascita 		= $conascita;
$p->comuneResidenza     = $coresidenza;
$p->CAPResidenza        = $caresidenza;
$p->provinciaResidenza  = $prresidenza;
$p->indirizzo 			= $indirizzo;
$p->civico   			= $civico;
$p->timestamp           = time();
$p->consenso            = time();

if ( (int) $sessione->tipoRegistrazione == VOLONTARIO ) {
    $p->stato               = PERSONA;
} else {
    $p->stato               = ASPIRANTE;
}



/*
 * Associa la sessione all'utente...
 */
$sessione->utente = $p->id;


/*
 * Continuiamo la registrazione...
 */
redirect('nuovaAnagraficaContatti');