<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>

<h3><i class="icon-bolt muted"></i> Procedura di importazione automatica dal format CSV</h3>

<pre><code>
    <?php

    

    $file = $_FILES['inputCSV']['tmp_name'];
    if ($file == '') {
        redirect('admin.format&f');
    }
    
    $file = fopen($file, 'r');

    /* Scarica il primo rigo di intestazione */
    $legenda = fgetcsv($file, 0, ';');
    $i=0;
    $h = 0;

    $rigasuexcel = 0;

    while ( $riga = fgetcsv($file, 0, ';') ) {
        set_time_limit(0);
        /* Scarica il codice fiscale... */
        $codiceFiscale = maiuscolo($riga[4]);
        echo('['.$rigasuexcel.']: '.$codiceFiscale);
        $rigasuexcel++;

        /* Controlla se esiste già! */
        if ($p = Persona::by('codiceFiscale', $codiceFiscale) && isset($_POST['fixproblem'])) {
            $v = new Volontario($p->id);
            if ($v->numeroAppartenenzeAttuali() > 0) {
                echo(' appartiene a '.$v->unComitato()->nomeCompleto().'<br>');
                continue;
            }

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
            
            $v->cambiaPassword($password);
            echo(' PASSWORD GENERATA');

            $dingresso   = DateTime::createFromFormat('d/m/Y', $riga[12]);
            $dingresso   = $dingresso->getTimestamp();

            /* format con pass e conferma*/
            $app = new Appartenenza();
            $comitato = Comitato::by('nome', $riga[13]);
            $pres = $comitato->unPresidente();
            $app->comitato = $comitato->id;
            $app->volontario = $v->id;
            $app->inizio = $dingresso;
            $app->fine = PROSSIMA_SCADENZA;
            $app->timestamp   = time();
            $app->stato     = MEMBRO_VOLONTARIO;
            $app->conferma  = $pres;

            $haemail = false;
            if ($v->email == '') {
                $haemail = true;
            }
            
            if ($haemail) {
                $m = new Email('registrazioneFormatpass', 'Registrato su Gaia');
                $m->a = $v;
                $m->_NOME       = $v->nome;
                $m->_PASSWORD   = $password;
                $m->invia();
                echo(' INVIATA EMAIL');
            }
            echo(' APPARTENENZA GENERATA su '.$comitato->nomeCompleto().'<br>');
            continue;

            
        }

        if ( $p = Persona::by('codiceFiscale', $codiceFiscale) ) {
            echo(' cf duplicato :( <br>');
            continue; /* Andiamo avanti con la vita, ci sei già amico, il prossimo! */
        }
        $h++; 
        /* Imposta la data di nascita */
        $dnascita   = DateTime::createFromFormat('d/m/Y', $riga[2]);
        $dnascita   = $dnascita->getTimestamp();

        
        /* Carica i vari dati... */
        $p = new Volontario();
        $p->codiceFiscale       = $codiceFiscale;
        $p->nome                = normalizzaNome($riga[0]);
        $p->cognome             = normalizzaNome($riga[1]);

        echo(' importo! '.$p->nome.' '.$p->cognome);

        $p->consenso = true;
        if (intval(substr($p->codiceFiscale, 9, 2)) < 40){
            $p->sesso = UOMO;
        }else{
            $p->sesso = DONNA;
        }


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
        echo(' PASSWORD GENERATA');
        

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
        if ($p->email == '') {
            $haemail = true;
        } else {
            $haemail = flase;
        }
        
        $cell = maiuscolo($riga[11]);
        $cell = str_replace(', ', ' / ', $cell);
        $cell = str_replace('', ' ', $cell);
        $cell = str_replace('-', '', $cell);
        $p->cellulare = $cell;
        
        /* Imposta la data di nascita */
        $dingresso   = DateTime::createFromFormat('d/m/Y', $riga[12]);
        $dingresso   = $dingresso->getTimestamp();

        $app = null;
        $pres = null;


        /* format con pass e conferma*/
        $app = new Appartenenza();
        $comitato = Comitato::by('nome', $riga[13]);
        $pres = $comitato->unPresidente();
        $comitato = $comitato->id;
        $app->comitato = $comitato;
        $app->volontario = $p->id;
        $app->inizio = $dingresso;
        $app->fine = PROSSIMA_SCADENZA;
        $app->timestamp   = time();
        $app->stato     = MEMBRO_VOLONTARIO;
        $app->conferma  = $pres;
        if ($haemail) {
            $m = new Email('registrazioneFormatpass', 'Registrato su Gaia');
            $m->a = $p;
            $m->_NOME       = $p->nome;
            $m->_PASSWORD   = $password;
            $m->invia();
            echo(' INVIATA EMAIL');
        }
        echo(' APPARTENENZA GENERATA');

        
        if ( isset($_POST['inputQuote']) ){
            $t = new Quota();
            $t->appartenenza = $app->id;
            $time = date('Y', time());
            $time = mktime(0,0,0,1,1,$time);
            $t->timestamp = $time;
            $t->tConferma = time();
            $t->pConferma = $pres;
            $t->quota = QUOTA_RINNOVO;
            $t->causale = "Versamento quota di rinnovo annuale";
            echo(' INSERITA QUOTA');
        }

        if ($riga[14] == '') {
            $riserva = false;    
        } else {
            $riserva = true;    
        }
        

        if ($riserva){
            $r = new Riserva();
            $r->stato = RISERVA_OK;
            $r->appartenenza = $app->id;
            $r->volontario = $p->id;
            $inizio = @DateTime::createFromFormat('d/m/Y', $riga[14] );
            $inizio = @$inizio->getTimestamp();
            $r->inizio = $inizio;
            $fine = @DateTime::createFromFormat('d/m/Y', $riga[15] );
            $fine = @$fine->getTimestamp();
            $r->fine = $fine;
            $r->protNumero = $riga[16];
            $protData = @DateTime::createFromFormat('d/m/Y', $riga[17] );
            $protData = @$protData->getTimestamp();
            $r->protData = $protData;
            $r->motivo = $riga[18];
            $r->timestamp = time();
            $r->pConferma = $pres;
            $r->tConferma = time();
            echo(' INSERITA RISERVA');
        }

        if ($haemail) {
            $m = new Email('registrazioneFormat', 'Registrati su Gaia');
            $m->a = $p;
            $m->_NOME       = $p->nome;
            $m->invia();
            echo(' ALTRA EMAIL');   
        }
        echo(' fine inserimento :)<br>');
    }

echo "Sono stati caricati: $h utenti";
fclose($file);
?>
</code></pre>