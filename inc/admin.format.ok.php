<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
$ordinario = false;
if(isset($_POST['ordinario'])){
    $ordinario = true;
}
?>

<h3><i class="icon-bolt muted"></i> Procedura di importazione automatica dal format CSV</h3>

<pre>
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

    $_comitato = false;
    if (isset($_POST['inputComitato'])) {
        $_comitato =  Comitato::id($_POST['inputComitato']);
    }

    while ( $riga = fgetcsv($file, 0, ';') ) {

        set_time_limit(0);

        if (isset($_POST['trasferisci']) ) {
            $codiceFiscale = maiuscolo($riga[0]);
            echo('['.$rigasuexcel.']: '.$codiceFiscale);
            $rigasuexcel++;

            $v = Volontario::by('codiceFiscale', $codiceFiscale);
            
            if (!$v){
                echo " Volontario non presente!<br/>";
                continue;
            }

            echo " Trasferisco";
            $app = $v->appartenenzaAttuale();

            $comitato = Comitato::by('nome', $riga[1]);

            if (!$app){
                echo " Nessuna appartenenza attuale<br/>";
                continue;
            }

            if (!$comitato){
                echo " Comitato inesistente!<br/>";
                continue;
            }

            $app->comitato = $comitato->id;
            echo " Trasferimento effettuato <br/>";
            $h++;
            continue;
            
        }

        if (isset($_POST['trasferisciProc']) ) {
            $codiceFiscale = maiuscolo($riga[0]);
            echo "[{$rigasuexcel}] {$codiceFiscale} ";
            $rigasuexcel++;

            if (!$_comitato) {
                echo "ERRORE Nessun Comitato di destinazione selezionato. TERMINO.<br />";
                break;
            }

            $v = Volontario::by('codiceFiscale', $codiceFiscale);
            
            if (!$v){
                echo "ERRORE Volontario non presente!<br/>";
                continue;
            }

            $app = $v->appartenenzaAttuale();

            if (!$app){
                echo "ERRORE Nessuna appartenenza attuale<br/>";
                continue;
            }

            if ($app->comitato() == $_comitato) {
                echo "ERRORE Volontario gia' presso comitato di destinazione<br />";
                continue;
            }

            $motivo = $riga[2];
            if (!$motivo) {
                echo "ERRORE Nessuna motivazione specificata<br />";
                continue;
            }

            $quando = $riga[1];
            $quando = $quando ? DT::createFromFormat('d/m/Y', $quando) : false;
            if (!$quando) {
                echo "ERRORE Nessuna data valida<br />";
                continue;
            }
            $quando = $quando->getTimestamp();

            if ( $quando < (time()-(ANNO*150))){
                $anno = date('Y', $quando);
                echo " ERRORE Data non valida, anno improbabile {$anno} (forse usato formato anno due cifre?)<br/>";
                continue;
            }

            $a = new Appartenenza();
            $a->volontario  = $v;
            $a->comitato    = $_comitato;
            $a->stato =     TRASF_INCORSO;
            $a->timestamp = time();
            $a->inizio    = $quando;
            
            $t = new Trasferimento();
            $t->stato = TRASF_INCORSO;
            $t->appartenenza = $a;
            $t->volontario = $v;
            $t->motivo = $motivo;
            $t->timestamp = $quando;
            $t->protData = $quando;
            $t->cProvenienza = $app->comitato()->id;
        
            $t->trasferisci(true, $quando);

            echo "OK!    Trasferimento effettuato con procedura.<br/>";
            $h++;
            continue;
            
        }
        
        /* Scarica il codice fiscale... */
        $codiceFiscale = maiuscolo($riga[4]);
        echo('['.$rigasuexcel.']: '.$codiceFiscale);
        $rigasuexcel++;

        if ($ordinario){
            $dingresso   = DateTime::createFromFormat('d/m/Y', $riga[12]);
        }else{
            $dingresso   = DateTime::createFromFormat('d/m/Y', $riga[14]);
        }

        if ( $dingresso->getTimestamp() < (time()-(ANNO*150))){
            echo " Data ingresso antecedente a 150 anni - NON CARICATO!!! <br/>";
            continue;
        }
        /* Controlla se esiste già! */

        $v = Volontario::by('codiceFiscale', $codiceFiscale);

        if (isset($_POST['invertiCsv']) && $v) {
            echo " Inverto";
            $nome       = $v->nome;
            $cognome    = $v->cognome;
            $v->nome    = $cognome;
            $v->cognome = $nome;
            echo " Inversione Completa<br/>";
            continue;
        }

        if (isset($_POST['cancellaCsv']) && $v) {
            $v->cancellaUtente();
            continue;
        }

        if ($v && isset($_POST['resetPassword'])) {
            /* Genera e cambia la password casuale */
            $password = generaStringaCasuale(8, DIZIONARIO_ALFANUMERICO);
            $v->cambiaPassword($password);
            echo(' PASSWORD RIGENERATA');

            if ($v->email) {
                $m = new Email('registrazioneFormatpass', 'Registrato su Gaia');
                $m->a = $v;
                $m->_NOME       = $v->nome;
                $m->_PASSWORD   = $password;
                $m->invia();
                echo(' INVIATA EMAIL A: '.$v->email.' <br>');
            }

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

            if (intval(substr($codiceFiscale, 9, 2)) < 40){
                $p->sesso = UOMO;
            }else{
                $p->sesso = DONNA;
            }

            if($ordinario){
                $p->stato = PERSONA; /* format con pass e conferma*/ 
                $cell = maiuscolo($riga[11]);
            }else{
                $p->stato = VOLONTARIO; /* format con pass e conferma*/ 
                $cell = maiuscolo($riga[12]);
                $p->emailServizio       = minuscolo($riga[11]);
                $cells = maiuscolo($riga[13]);
                $cells = str_replace(', ', ' / ', $cells);
                $cells = str_replace('', ' ', $cells);
                $cells = str_replace('-', '', $cells);
                $p->cellulareServizio = $cells;
            }
            
            $p->timestamp = time(); /* format con pass e conferma*/
            
            /* Genera e cambia la password casuale */
            $password = generaStringaCasuale(8, DIZIONARIO_ALFANUMERICO);
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
                
                $email = minuscolo($riga[10]);
                if(filter_var($email, FILTER_VALIDATE_EMAIL) 
                    && !Persona::by('email', $email)) {
                   $p->email = $email; 
                }
                
                $cell = str_replace(', ', ' / ', $cell);
                $cell = str_replace('', ' ', $cell);
                $cell = str_replace('-', '', $cell);
                $p->cellulare = $cell;

                $app = null;
                $pres = null;

                /* format con pass e conferma*/
                $app = new Appartenenza();
                if($ordinario){
                    /* Imposta la data di ingresso in CRI */
                    $dingresso   = DateTime::createFromFormat('d/m/Y', $riga[12]);
                    $dingresso   = $dingresso->getTimestamp();
                    $app->stato     = MEMBRO_ORDINARIO;
                    $comitato = Comitato::by('nome', $riga[13]);
                }else{
                    /* Imposta la data di ingresso in CRI */
                    $dingresso   = DateTime::createFromFormat('d/m/Y', $riga[14]);
                    $dingresso   = $dingresso->getTimestamp();
                    $app->stato     = MEMBRO_VOLONTARIO;
                    $comitato = Comitato::by('nome', $riga[15]);
                }
                $pres = $comitato->unPresidente();
                $comitato = $comitato->id;
                $app->comitato = $comitato;
                $app->volontario = $p->id;
                $app->inizio = $dingresso;
                $app->fine = PROSSIMA_SCADENZA;
                $app->timestamp   = time();
                $app->conferma  = $pres;
                if ($p->email) {
                    $m = new Email('registrazioneFormatpass', 'Registrato su Gaia');
                    $m->a = $p;
                    $m->_NOME       = $p->nome;
                    $m->_PASSWORD   = $password;
                    $m->invia();
                    echo(' INVIATA EMAIL');
                }
                echo(' APPARTENENZA GENERATA');

                if ( !empty($riga[16]) && !empty($riga[17]) ) {
                    $riserva = true;    
                } else {
                    $riserva = false;    
                }
                
                if ($riserva && !$ordinario){
                    $r = new Riserva();
                    $r->stato = RISERVA_OK;
                    $r->appartenenza = $app->id;
                    $r->volontario = $p->id;
                    $inizio = @DateTime::createFromFormat('d/m/Y', $riga[16] );
                    $inizio = @$inizio->getTimestamp();
                    $r->inizio = $inizio;
                    $fine = @DateTime::createFromFormat('d/m/Y', $riga[17] );
                    $fine = @$fine->getTimestamp();
                    $r->fine = $fine;
                    $r->protNumero = $riga[18];
                    $protData = @DateTime::createFromFormat('d/m/Y', $riga[19] );
                    $protData = @$protData->getTimestamp();
                    $r->protData = $protData;
                    $r->motivo = $riga[20];
                    $r->timestamp = time();
                    $r->pConferma = $pres;
                    $r->tConferma = time();
                    echo(' INSERITA RISERVA');
                }

                if ($riga[21] == '') {
                    $ffaa = false;    
                } else {
                    $ffaa = true;    
                }

                if ($ffaa && !$ordinario){
                    $ffaa = maiuscolo($riga[21]);
                    if ( $ffaa=="IV" && $p->sesso == DONNA ) {
                        $p->iv = "on";
                    }elseif( $ffaa=="CMV" && $p->sesso == UOMO ) {
                        $p->cm = "on";
                    }

                    echo(' INSERITA FFAA');
                }

                echo(' fine inserimento :)<br>');
            }

            echo "Sono stati caricati: $h utenti";
            fclose($file);
            ?>
        </code>