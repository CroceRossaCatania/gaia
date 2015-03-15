<?php  

/*
 * ©2015 Croce Rossa Italiana
 */

paginaApp(APP_PRESIDENTE);

$parametri = array('inputComitato', 'inputCodiceFiscale', 'inputNome',
	'inputCognome', 'inputDataNascita', 'inputEmail');

controllaParametri($parametri, 'us.dash&err');

$comitato = $_POST['inputComitato'];
$comitato = GeoPolitica::daOid($comitato);
$oid = $comitato->oid();
$app = (int) $_POST['inputApplicazione'];

$codiceFiscale  = $_POST['inputCodiceFiscale'];
$codiceFiscale  = maiuscolo($codiceFiscale);
$email      	= minuscolo($_POST['inputEmail']);

$indietro = "presidente.comitato.dipendneti.nuovo&applicazione={$app}&comitato={$oid}";

/* Controlli */
/* Cerca anomalie nel formato del codice fiscale */
if ( !preg_match("/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/", $codiceFiscale) ) {
    redirect("{$indietro}&e");
}

/* Cerca eventuali utenti con la stessa email... */
$e = Utente::by('email', $email);
if ( $e ) {
    /* Se l'utente esiste, ed ha già pure una password */
    redirect("{$indietro}&mail");
}

$p = new Utente();
$p->codiceFiscale = $codiceFiscale;

/*
 * Normalizzazione dei dati
 */
$id          = $p->id;
$nome        = normalizzaNome($_POST['inputNome']);
$cognome     = normalizzaNome($_POST['inputCognome']);
$sesso    	 = $_POST['inputSesso'];
$dnascita 	 = DT::createFromFormat('d/m/Y', $_POST['inputDataNascita']);
$dnascita 	 = $dnascita->getTimestamp();
$prnascita 	 = maiuscolo($_POST['inputProvinciaNascita']);
$conascita 	 = normalizzaNome($_POST['inputComuneNascita']);

/*
 * Registrazione vera e propria...
 */
$p->nome                = $nome;
$p->cognome             = $cognome;
$p->sesso               = $sesso;
$p->dataNascita         = $dnascita;
$p->provinciaNascita    = $prnascita;
$p->comuneNascita       = $conascita;
$p->timestamp           = time();
$p->stato               = PERSONA;

$p->dipendenteComitato  = $oid;

/*
 * Normalizzazione dei dati
 */
$cell       = normalizzaNome($_POST['inputCellulare']);

$p->email               = $email;
$p->cellulare           = $cell;

/* Genera la password casuale */
$password = generaStringaCasuale(8, DIZIONARIO_ALFANUMERICO);

/* Imposta la password */
$p->cambiaPassword($password);

/* Invia la mail */
$m = new Email('registrazioneDipendente', 'Attivazione come Dipendente su Gaia');
$m->a = $p;
$m->da = $me;
$m->_NOME       = $p->nome;
$m->_EMAIL 		= $p->email;
$m->_COMITATO   = $comitato->nomeCompleto();
$m->_PASSWORD   = $password;
$m->invia();

// Nomina come delegato US
redirect("presidente.comitato.delegato&applicazione={$app}&oid={$oid}&persona={$p->id}");
