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
   
   $i++; 
    /* Scarica il codice fiscale... */
    $codiceFiscale = maiuscolo($riga[4]);
    
    /* Controlla se esiste già! */
    if ( $p = Persona::by('codiceFiscale', $codiceFiscale) ) {
        continue; /* Andiamo avanti con la vita, ci sei già amico, il prossimo! */
    }
    
    /* Imposta la data di nascita */
    $dnascita   = DateTime::createFromFormat('d/m/Y', $riga[2]);
    $dnascita   = $dnascita->getTimestamp();

    
    /* Carica i vari dati... */
    $p = new Volontario();
    $p->codiceFiscale       = $codiceFiscale;
    $p->nome                = normalizzaNome($riga[0]);
    $p->cognome             = normalizzaNome($riga[1]);
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
    
    $m = new Email('registrazioneFormat', 'Registrati su Gaia');
    $m->a = $p;
    $m->_NOME       = $p->nome;
    $m->invia();
      
    
}
echo "Sono stati caricati: $i utenti";
fclose($file);
?>
</code></pre>