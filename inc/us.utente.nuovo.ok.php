<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$comitato = $_POST['inputComitato'];
if ( !$comitato ) {
    redirect('us.utente.nuovo&c');
}
$comitato = new Comitato($comitato);
if ( !in_array($comitato, $me->comitatiApp([APP_SOCI, APP_PRESIDENTE])) ) {
    redirect('us.utente.nuovo&c');
}

$codiceFiscale = $_POST['inputCodiceFiscale'];
$codiceFiscale = maiuscolo($codiceFiscale);
$email      = minuscolo($_POST['inputEmail']);

/* Controlli */
/* Cerca anomalie nel formato del codice fiscale */
if ( !preg_match("/^[A-Z]{6}[0-9]{2}[A-Z][A-Z0-9]{2}[A-Z][A-Z0-9]{3}[A-Z]$/", $codiceFiscale) ) {
	redirect('us.utente.nuovo&e');
}

/* Cerca eventuali utenti con la stessa email... */
$e = Utente::by('email', $email);
if ( $e and $e->password ) {
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
$dnascita = DT::createFromFormat('d/m/Y', $_POST['inputDataNascita']);
$dnascita = $dnascita->getTimestamp();
$prnascita= maiuscolo($_POST['inputProvinciaNascita']);
$conascita = normalizzaNome($_POST['inputComuneNascita']);
$coresidenza= normalizzaNome($_POST['inputComuneResidenza']);
$caresidenza= normalizzaNome($_POST['inputCAPResidenza']);
$prresidenza= maiuscolo($_POST['inputProvinciaResidenza']);
$indirizzo  = normalizzaNome($_POST['inputIndirizzo']);
$civico     = maiuscolo($_POST['inputCivico']);
$grsanguigno = maiuscolo($_POST['inputgruppoSanguigno']);

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

/* Crea la password casuale */
$length = 6;

// impostare password bianca
$password = "";

// caratteri possibili
$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

 //massima lunghezza caratteri
 $maxlength = strlen($possible);
  
 // se troppo lunga taglia la password
if ($length > $maxlength) {
      $length = $maxlength;
}
    
$i = 0; 
    
 // aggiunge carattere casuale finchè non raggiunge lunghezza corretta
 while ($i < $length) { 

    // prende un carattere casuale per creare la password
   $char = substr($possible, mt_rand(0, $maxlength-1), 1);

    // verifica se il carattere precedente è uguale al successivo
   if (!strstr($password, $char)) { 
        $password .= $char;
        $i++;
   }

}

/* Imposta la password */
$p->cambiaPassword($password);

/* Invia la mail */
$m = new Email('registrazioneVolontario', 'Benvenuto su Gaia');
$m->a = $p;
$m->_NOME       = $p->nome;
$m->_PASSWORD   = $password;
$m->invia();


redirect('presidente.utente.visualizza&ok&id='.$p->id);