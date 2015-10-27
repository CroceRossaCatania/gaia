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

$p = Civile::by('codiceFiscale', $codiceFiscale);
if ($p) {
    redirect('&gia');
} else {
    $p = new Civile();
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
$p->stato               = PERSONA;
$p->consenso = true;

/*
 * Normalizzazione dei dati
 */
$cell       = normalizzaNome($_POST['inputCellulare']);

$p->email               = $email;
$p->cellulare           = $cell;

echo '<p>Utente salvato correttamente. Ora puoi inserirlo cercandolo per codice fiscale:</p>';
echo '<p>'.$codiceFiscale.'</p>';
