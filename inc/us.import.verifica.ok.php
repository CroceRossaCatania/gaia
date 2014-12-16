<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$ordinario = false;
if(isset($_POST['ordinario'])){
    $ordinario = true;
}
?>

<h3><i class="icon-bolt muted"></i> Procedura di verifica del file di importazione automatica</h3>

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
    try{
        while ( $riga = fgetcsv($file, 0, ';') ) {
            set_time_limit(0);
            /* Scarica il codice fiscale... */
            $codiceFiscale = maiuscolo($riga[4]);
            echo('['.$rigasuexcel.']: '.$codiceFiscale);
            $rigasuexcel++;

            if ($ordinario){
                if ( !DT::controlloData($riga[12]) )
                    echo "<b>Errore!</b> data ingresso non corretta <br/>";
                    continue;
            }else{
                if ( !DT::controlloData($riga[14]) )
                    echo "<b>Errore!</b> data ingresso non corretta <br/>";
                    continue;
            }

            if ( $dingresso && $dingresso->getTimestamp() < (time()-(ANNO*150))){
                echo "<b>Errore!</b> Data ingresso antecedente a 150 anni <br/>";
                continue;
            }

            /* Controlla se esiste già! */

            if ( $p = Persona::by('codiceFiscale', $codiceFiscale) ) {
                echo('<b>Errore!</b> Persona gia su Gaia! <br/>');
                continue;
            }

            /* Imposta la data di nascita */
            if ( !DT::controlloData($riga[2]) ){
                echo "<b>Errore!</b> data di nascita non corretta  <br/>";
                continue;
            }
                
            /* Verifica i vari dati... */
            echo(' verifico! '.$riga[0].' '.$riga[1]);

            if (intval(substr($codiceFiscale, 9, 2)) < 40){
                echo " - UOMO ";
            }else{
                echo " - DONNA ";
            }

            if($ordinario){
                echo maiuscolo($riga[11]);
            }else{
                echo maiuscolo($riga[12]);
                echo maiuscolo($riga[13]);
            }

            $xyz = explode(' (', $riga[3]);
            echo normalizzaNome($xyz[0]);
                    
            if ( isset($xyz[1]) ) {
                echo " provincia nascita: ", maiuscolo ( str_replace(')', '', $xyz[1] ) );
            }

            $p->indirizzo           = normalizzaNome($riga[5]);
            $p->civico              = normalizzaNome($riga[6]);
            $p->comuneResidenza     = normalizzaNome($riga[7]);
            $p->provinciaResidenza  = maiuscolo($riga[8]);
            $p->CAPResidenza        = maiuscolo($riga[9]);
                    
            $email = minuscolo($riga[10]);
            if(filter_var($email, FILTER_VALIDATE_EMAIL) 
                && !Persona::by('email', $email)) {
               echo "email OK"; 
            }

            $app = null;
            $pres = null;

            echo " comitato:", Comitato::by('nome', $riga[15]);

            if ($riga[16] == '') {
                $riserva = false;    
            } else {
                echo "Presente una riserva";
                $riserva = true;    
            }
                    
            if ($riserva && !$ordinario){
                $inizio = @DateTime::createFromFormat('d/m/Y', $riga[16] );
                $inizio = @$inizio->getTimestamp();
                $fine = @DateTime::createFromFormat('d/m/Y', $riga[17] );
                $fine = @$fine->getTimestamp();
                $protData = @DateTime::createFromFormat('d/m/Y', $riga[19] );
                $protData = @$protData->getTimestamp();
                echo('RISERVA');
            }

            if ($riga[21] == '') {
                $ffaa = false;    
            } else {
                $ffaa = true;    
            }

            if ($ffaa && !$ordinario){
                $ffaa = maiuscolo($riga[21]);
                if ( $ffaa=="IV" && $p->sesso == DONNA ) {
                }elseif( $ffaa=="CMV" && $p->sesso == UOMO ) {
                }

                echo(' INSERITA FFAA');
            }

            echo(' fine inserimento :)<br>');

            }
        }catch (Exception $e) {
            var_dump($e);
        }

            echo "File verificato";
            fclose($file);
            ?>
        </code></pre>