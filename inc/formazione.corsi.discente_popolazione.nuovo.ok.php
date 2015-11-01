<?php  
/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale(null, null, APP_OBIETTIVO, OBIETTIVO_1);

$parametri = array('inputCodiceFiscale', 'inputNome',
	'inputCognome', 'inputDataNascita', 'inputProvinciaNascita',
	'inputComuneNascita');

controllaParametri($parametri, '&err');
/*
$comitato = $_POST['inputComitato'];
if ( !$comitato ) {
    redirect('us.utente.nuovo&c');
}
$comitato = Comitato::id($comitato);
if ( !in_array($comitato, $me->comitatiApp([APP_SOCI, APP_PRESIDENTE])) ) {
    redirect('us.utente.nuovo&c');
}
*/

$codiceFiscale = $_POST['inputCodiceFiscale'];
$codiceFiscale = maiuscolo($codiceFiscale);
$email      = minuscolo($_POST['inputEmail']);

/* Controlli */
/* Cerca anomalie nel formato del codice fiscale */
if ( !preg_match("/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/", $codiceFiscale) ) {
    redirect('&e');
}

/* Cerca eventuali utenti con la stessa email... */
$e = Utente::by('email', $email);
if ( $e && $email && $e->password ) {
    /* Se l'utente esiste, ed ha già pure una password */
    redirect('&mail');
}

$c = Civile::by('codiceFiscale', $codiceFiscale);
if ($c) {
    redirect('&gia');
} else {
    $c = new Civile();
    $c->codiceFiscale = $codiceFiscale;
}

/*
 * Normalizzazione dei dati
 */
$id         = $c->id;
$nome       = normalizzaNome($_POST['Nome']);
$cognome    = normalizzaNome($_POST['Cognome']);
$sesso    = $_POST['Sesso'];
$dnascita = DT::createFromFormat('d/m/Y', $_POST['DataNascita']);
$dnascita = $dnascita->getTimestamp();
$prnascita= maiuscolo($_POST['ProvinciaNascita']);
$conascita = normalizzaNome($_POST['ComuneNascita']);
$coresidenza= normalizzaNome($_POST['ComuneResidenza']);
$caresidenza= normalizzaNome($_POST['CAPResidenza']);
$prresidenza= maiuscolo($_POST['ProvinciaResidenza']);
$indirizzo  = normalizzaNome($_POST['Indirizzo']);
$civico     = maiuscolo($_POST['Civico']);

/*
 * Registrazione vera e propria...
 */
$c->nome                = $nome;
$c->cognome             = $cognome;
$c->sesso               = $sesso;
$c->dataNascita         = $dnascita;
$c->provinciaNascita    = $prnascita;
$c->comuneNascita       = $conascita;
$c->comuneResidenza     = $coresidenza;
$c->CAPResidenza        = $caresidenza;
$c->provinciaResidenza  = $prresidenza;
$c->indirizzo 		      = $indirizzo;
$c->civico   		        = $civico;
$c->timestamp           = time();
$c->stato               = PERSONA;
$c->consenso = true;

/*
 * Normalizzazione dei dati
 */
$cell       = normalizzaNome($_POST['inputCellulare']);

$c->email               = $email;
$c->cellulare           = $cell;

echo '<p>Utente salvato correttamente. Ora puoi inserirlo cercandolo per codice fiscale:</p>';
echo '<p>'.$codiceFiscale.'</p>';
