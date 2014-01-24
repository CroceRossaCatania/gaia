<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$parametri = array('inputComitato', 'inputCodiceFiscale', 'inputNome',
	'inputCognome', 'inputDataNascita', 'inputDataQuota', 'inputProvinciaNascita',
	'inputComuneNascita', 'inputQuota');

controllaParametri($parametri, 'us.dash&err');

$comitato = $_POST['inputComitato'];
if ( !$comitato ) {
    redirect('us.ordinario.nuovo&c');
}
$comitato = Comitato::id($comitato);
if ( !in_array($comitato, $me->comitatiApp([APP_SOCI, APP_PRESIDENTE])) ) {
    redirect('us.ordinario.nuovo&c');
}

$anno = date('Y');
$dataQuota = DT::createFromFormat('d/m/Y', $_POST['inputDataQuota']);
$t = Tesseramento::by('anno', $anno); 
if ($dataQuota < $t->inizio()){
	redirect('us.ordinario.nuovo&q');
}

$importo = (float) $_POST['inputQuota'];
$importo = round($importo, 2);
if ($importo < $t->ordinario) {
	redirect('us.ordinario.nuovo&i');
}

$codiceFiscale  = $_POST['inputCodiceFiscale'];
$codiceFiscale  = maiuscolo($codiceFiscale);
$email      	= minuscolo($_POST['inputEmail']);

/* Controlli */
/* Cerca anomalie nel formato del codice fiscale */
if ( !preg_match("/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/", $codiceFiscale) ) {
	redirect('us.ordinario.nuovo&e');
}

/* Cerca eventuali utenti con la stessa email... */
$e = Utente::by('email', $email);
if ( $e and $e->password ) {
    /* Se l'utente esiste, ed ha già pure una password */
    redirect('us.ordinario.nuovo&mail');
}

$p = Persona::by('codiceFiscale', $codiceFiscale);

if ($p) {
            redirect('us.ordinario.nuovo&gia');

} else {
	$p = new Utente();
	$p->codiceFiscale = $codiceFiscale;
}

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
$coresidenza = normalizzaNome($_POST['inputComuneResidenza']);
$caresidenza = normalizzaNome($_POST['inputCAPResidenza']);
$prresidenza = maiuscolo($_POST['inputProvinciaResidenza']);
$indirizzo   = normalizzaNome($_POST['inputIndirizzo']);
$civico      = maiuscolo($_POST['inputCivico']);

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
$p->indirizzo 		    = $indirizzo;
$p->civico   		    = $civico;
$p->timestamp           = time();
$p->stato               = PERSONA;

/*
 * Normalizzazione dei dati
 */
$cell       = normalizzaNome($_POST['inputCellulare']);

$p->email               = $email;
$p->cellulare           = $cell;

$gia = Appartenenza::filtra([
	['volontario', $p->id],
	['comitato', $comitato->id]
]);

if(!$gia){
	$a = new Appartenenza();
	$a->volontario  = $p->id;
	$a->comitato    = $comitato;
	$inizio 		= DT::createFromFormat('d/m/Y', $_POST['inputDataQuota']);
	$inizio 		= $inizio->getTimestamp();
	$a->inizio      = $inizio;
	$a->fine        = PROSSIMA_SCADENZA;
	$a->timestamp 	= time();
	$a->stato     	= MEMBRO_ORDINARIO;
	$a->conferma  	= $me;
}

/* Generazione della quota */

$q = new Quota();
$q->appartenenza 	= $a;
$q->timestamp 		= time();
$q->tConferma 		= time();
$q->pConferma 		= $me;
$q->anno 			= $anno;
$q->assegnaProgressivo();
$q->quota 			= $importo;

$quotaBen = $t->ordinario + (float) $a->comitato()->quotaBenemeriti();
$q->causale 		= "Iscrizione socio ordinario CRI anno {$anno}"; 
if ($importo > $quotaBen) {
	$q->benemerito = BENEMERITO_SI;
	$q->offerta = "Promozione a socio sostenitore per l'anno {$anno} per il versamento di una quota superiore a " . soldi($quotaBen) . " &#0128;.";
}

/* Crea la ricevuta del pagamento della quota */
$l = new PDF('ricevutaquota', 'ricevuta.pdf');
$l->_COMITATO 	= $a->comitato()->locale()->nomeCompleto();
$l->_INDIRIZZO 	= $a->comitato()->locale()->formattato;
$l->_ID 		= $q->progressivo();
$l->_NOME 		= $p->nome;
$l->_COGNOME 	= $p->cognome;
$l->_FISCALE 	= $p->codiceFiscale;
$l->_NASCITA 	= date('d/m/Y', $p->dataNascita);
$l->_LUOGO 		= $p->luogoNascita;
$l->_IMPORTO	= soldi($q->quota - ($q->quota - $quotaMin));
$l->_QUOTA  	= $q->causale;
if ($q->q - $quotaMin > 0) {
	$l->_OFFERTA	= $q->offeta;
	$l->_OFFERIMPORTO = soldi($q->quota - $quotaMin) . "  &#0128; ";
} else {
	$l->_OFFERTA	= '';
	$l->_OFFERIMPORTO = '';
}
$l->_TOTALE		= soldi($quota->quota);
$l->_LUOGO 		= $a->comitato()->locale()->comune;
$l->_DATA 		= date('d-m-Y', time());
$l->_CHINOME	= $me->nomeCompleto();
$l->_CHICF		= $me->codiceFiscale;
$f = $l->salvaFile();  



/* Genera la password casuale */
$password = generaStringaCasuale(8, DIZIONARIO_ALFANUMERICO);

/* Imposta la password */
$p->cambiaPassword($password);

/* Invia la mail */
$m = new Email('registrazioneOrdinario', 'Benvenuto su Gaia');
$m->a = $p;
$m->_NOME       = $p->nome;
$m->_PASSWORD   = $password;
$m->allega($f);
$m->invia();

redirect('presidente.utente.visualizza&ok&id='.$p->id);
