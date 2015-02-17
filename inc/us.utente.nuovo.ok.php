<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$parametri = array('inputComitato', 'inputCodiceFiscale', 'inputNome',
	'inputCognome', 'inputDataNascita', 'inputDataIngresso', 'inputProvinciaNascita',
	'inputComuneNascita');

controllaParametri($parametri, 'us.dash&err');

$comitato = $_POST['inputComitato'];
if ( !$comitato ) {
    redirect('us.utente.nuovo&c');
}
$comitato = Comitato::id($comitato);
if ( !in_array($comitato, $me->comitatiApp([APP_SOCI, APP_PRESIDENTE])) ) {
    redirect('us.utente.nuovo&c');
}

$codiceFiscale = $_POST['inputCodiceFiscale'];
$codiceFiscale = maiuscolo($codiceFiscale);
$email      = minuscolo($_POST['inputEmail']);

/* Controlli */
/* Cerca anomalie nel formato del codice fiscale */
if ( !preg_match("/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/", $codiceFiscale) ) {
	redirect('us.utente.nuovo&e');
}

/* Cerca eventuali utenti con la stessa email... */
$e = Utente::by('email', $email);
if ( $e && $email && $e->password ) {
    /* Se l'utente esiste, ed ha già pure una password */
    redirect('us.utente.nuovo&mail');
}

$p = Persona::by('codiceFiscale', $codiceFiscale);

if ($p) {
            redirect('us.utente.nuovo&gia');

} else {
	$p = new Volontario();
	$p->codiceFiscale = $codiceFiscale;
}

/*
 * Normalizzazione dei dati
 */
$id         = $p->id;
$nome       = normalizzaNome($_POST['inputNome']);
$cognome    = normalizzaNome($_POST['inputCognome']);
$sesso    = $_POST['inputSesso'];
$dnascita = DT::createFromFormat('d/m/Y', $_POST['inputDataNascita']);
$dnascita = $dnascita->getTimestamp();
$prnascita= maiuscolo($_POST['inputProvinciaNascita']);
$conascita = normalizzaNome($_POST['inputComuneNascita']);
$coresidenza= normalizzaNome($_POST['inputComuneResidenza']);
$caresidenza= normalizzaNome($_POST['inputCAPResidenza']);
$prresidenza= maiuscolo($_POST['inputProvinciaResidenza']);
$indirizzo  = normalizzaNome($_POST['inputIndirizzo']);
$civico     = maiuscolo($_POST['inputCivico']);

/*
 * Registrazione vera e propria...
 */
$p->nome                = $nome;
$p->cognome             = $cognome;
$p->sesso               = $sesso;
$p->dataNascita         = $dnascita;
$p->provinciaNascita    = $prnascita;
$p->comuneNascita       = $conascita;
$p->comuneResidenza     = $coresidenza;
$p->CAPResidenza        = $caresidenza;
$p->provinciaResidenza  = $prresidenza;
$p->indirizzo 		      = $indirizzo;
$p->civico   		        = $civico;
$p->timestamp           = time();
$p->stato               = VOLONTARIO;
$p->consenso = true;

/*
 * Normalizzazione dei dati
 */
$cell       = normalizzaNome($_POST['inputCellulare']);
$cells      = normalizzaNome(@$_POST['inputCellulareServizio']);

$p->email               = $email;
$p->cellulare           = $cell;
$p->cellulareServizio   = $cells;

$gia = Appartenenza::filtra([
	['volontario', $p->id],
	['comitato', $comitato->id]
]);

if(!$gia){
	$a = new Appartenenza();
	$a->volontario  = $p->id;
	$a->comitato    = $comitato;
	$inizio = DT::createFromFormat('d/m/Y', $_POST['inputDataIngresso']);
	$inizio = $inizio->getTimestamp();
	$a->inizio      = $inizio;
	$a->fine        = PROSSIMA_SCADENZA;
	$a->timestamp = time();
	$a->stato     = MEMBRO_VOLONTARIO;
	$a->conferma  = $me;
}

/* 
 * Non si può far parte di IV e CM contemporaneamente
 */

if ( !(isset($_POST['inputIV']) && isset($_POST['inputCM']))) {
    if( $p->sesso == DONNA){
        $p->iv = $_POST['inputIV'];
    }
    $p->cm = $_POST['inputCM'];

}

/* Genera la password casuale */
$password = generaStringaCasuale(8, DIZIONARIO_ALFANUMERICO);

/* Imposta la password */
$p->cambiaPassword($password);

/* Invia la mail */
$m = new Email('registrazioneVolontarioUS', 'Benvenuto su Gaia');
$m->a = $p;
$m->_NOME       = $p->nome;
$m->_PASSWORD   = $password;
$m->invia();


redirect('presidente.utente.visualizza&ok&id='.$p->id);