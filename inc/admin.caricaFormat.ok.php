<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaAdmin();

?>

<h3><i class="icon-bolt muted"></i> Procedura mostruosa automatica di importazione elettronica</h3>

<pre><code>
<?php

$file = $_FILES['inputCSV']['tmp_name'];
$file = fopen($file, 'r');

/* Scarica il primo rigo di intestazione */
 $legenda = fgetcsv($file, 0, ';');
 $i=0;
while ( $riga = fgetcsv($file, 0, ';') ) {
   set_time_limit(0);
    /* Scarica il codice fiscale... */
    $codiceFiscale = maiuscolo($riga[4]);
    
    /* Controlla se esiste già! */
    if ( $p = Persona::by('codiceFiscale', $codiceFiscale) ) {
        continue; /* Andiamo avanti con la vita, ci sei già amico, il prossimo! */
    }
    $i++; 
    /* Imposta la data di nascita */
    $dnascita   = DateTime::createFromFormat('d/m/Y', $riga[2]);
    $dnascita   = $dnascita->getTimestamp();

    
    /* Carica i vari dati... */
    $p = new Volontario();
    $p->codiceFiscale       = $codiceFiscale;
    $p->nome                = normalizzaNome($riga[0]);
    $p->cognome             = normalizzaNome($riga[1]);
    if (isset($_POST['pass'])) {
    $p->stato = VOLONTARIO; /* format con pass e conferma*/
    $p->timestamp = time(); /* format con pass e conferma*/
    
    /* format con pass e conferma*/
    
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
    
    $p->cambiaPassword($password);
    }
    $p->dataNascita         = $dnascita;
    $xyz = explode(' (', $riga[3]);
    $p->comuneNascita = normalizzaNome($xyz[0]);
    if ( isset($xyz[1]) ) {
            $p->provinciaNascita = maiuscolo ( str_replace(')', '', $xyz[1] ) );
    }
    $p->indirizzo           = normalizzaNome($riga[5]);
    $p->civico              = normalizzaNome($riga[6]);
    $p->comuneResidenza     = normalizzaNome($riga[7]);
    $p->provinciaResidenza  = maiuscolo($riga[8]);
    $p->CAPResidenza        = maiuscolo($riga[9]);
    $p->email               = minuscolo($riga[10]);
    
    $cell = maiuscolo($riga[11]);
    $cell = str_replace(', ', ' / ', $cell);
    $cell = str_replace('', ' ', $cell);
    $cell = str_replace('-', '', $cell);
    $p->cellulare = $cell;
    
    /* Imposta la data di nascita */
    $dingresso   = DateTime::createFromFormat('d/m/Y', $riga[12]);
    $dingresso   = $dingresso->getTimestamp();
    if (isset($_POST['pass'])) {
    /* format con pass e conferma*/
    $app = new Appartenenza();
    $comitato = Comitato::by('nome', $riga[13]);
    $comitato = $comitato->id;
    $t = Appartenenza::filtra([['stato', MEMBRO_PRESIDENTE],['comitato',$comitato]]);
    $app->comitato = $comitato;
    $app->volontario = $p->id;
    $app->inizio = $dingresso;
    $app->timestamp   = time();
    $app->stato     = MEMBRO_VOLONTARIO;
    $app->conferma  = $t[0]->volontario;
    $m = new Email('registrazioneFormatpass', 'Registrato su Gaia');
    $m->a = $p;
    $m->_NOME       = $p->nome;
    $m->_PASSWORD   = $password;
    $m->invia();
    }
    
    $m = new Email('registrazioneFormat', 'Registrati su Gaia');
    $m->a = $p;
    $m->_NOME       = $p->nome;
    $m->invia();
      
    
}
echo "Sono stati caricati: $i utenti";
fclose($file);
?>
</code></pre>




