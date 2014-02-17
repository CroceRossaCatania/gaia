<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

set_time_limit(0);
$inizio = time();
?>
<h3><i class="icon-wrench muted"></i> Manutenzione titoli</h3>
<pre>
    <code>
        Unione titoli doppioni:
        <?php
        $titoli = Titolo::elenco();
        $eseguiti=0;
        $nDoppioni = 0;
        echo "Start manutenzione titoli:<br/>";
        foreach( $titoli as $t ){
            $ripetuto = Titolo::filtra([['nome', $t->nome]]);
            if ( count($ripetuto) > 1 ){
                $eseguiti++; 
                echo("Titolo doppione {$t->id}: {$t->nome} <br />");
                // Prendo il secondo e vedo se esistono titoli personali
                $personali = TitoloPersonale::filtra([['titolo', $ripetuto[1]]]);
                foreach ( $personali as $personale ){
                    echo("Sostituisco titolo {$ripetuto[1]->id} con {$ripetuto[0]->id} <br />");
                    $personale->titolo = $ripetuto[0];
                }
                echo "Cancellazione di {$ripetuto[1]->id} <br/>";
                $ripetuto[1]->cancella();
            }
        }
        $fine = time();
        ?>
        Eseguite <strong><?= $eseguiti; ?></strong> riparazioni in <strong><?= $fine-$inizio; ?></strong> secondi.
    </code>
</pre>