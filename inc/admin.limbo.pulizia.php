<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>

<h3><i class="icon-bolt muted"></i> Procedura di pulizia del limbo</h3>

<pre>
<code>
    <?php
    if (isset($_GET['soft'])) 
    {
        echo('<br><strong>Avviata procedura di pulizia soft</strong><br><br>');
        $v = Volontario::elenco();
        $totale = 0;
        foreach($v as $_v) 
        {
            $appartenenze = $_v->numAppartenenzeTotali(MEMBRO_DIMESSO);
            if($appartenenze == 0 && !$_v->codiceFiscale && !$_v->nome && !$_v->cognome)
            {
                $totale++;
                echo('Anagrafica ID:['.$_v->id.'] senza CF, nome e cognome -> provvedo alla rimozione '.$_v->codiceFiscale.' '.$_v->nome.' '.$_v->cognome.'<br>');
                $_v->cancella();
            }
        }
    }
    if (isset($_GET['hard'])) 
    {
        echo('<br><strong>Avviata procedura di pulizia meno soft</strong><br><br>');
        $v = Volontario::elenco();
        foreach($v as $_v) 
        {
            $appartenenze = $_v->numAppartenenzeTotali(MEMBRO_DIMESSO);
            if($appartenenze == 0 && !$_v->nome && !$_v->cognome)
            {
                $totale++;
                echo('Anagrafica ID:['.$_v->id.'] senza nome e cognome -> provvedo alla rimozione di '.$_v->codiceFiscale.' '.$_v->nome.' '.$_v->cognome.'<br>');
                $_v->cancella();
            }
        }
    }
    if (isset($_GET['extreme'])) 
    {
        echo('<br><strong>Avviata procedura di pulizia ancora meno soft</strong><br><br>');
        $v = Volontario::elenco();
        foreach($v as $_v) 
        {
            $appartenenze = $_v->numAppartenenzeTotali(MEMBRO_DIMESSO);
            if($appartenenze == 0 && $_v->stato == NULL)
            {
                $totale++;
                echo('Anagrafica ID:['.$_v->id.'] senza stato -> provvedo alla rimozione di '.$_v->codiceFiscale.' '.$_v->nome.' '.$_v->cognome.'<br>');
                $f = TitoloPersonale::filtra([
                    ['volontario', $_v->id]
                ]);

                foreach ($f as $_f) {
                    $_f->cancella();
                }
                $_v->cancella();
            }
        }
    }

    if (isset($_GET['contatti'])) 
    {
        echo('<br><strong>Avviata procedura di pulizia per mancanza contatti</strong><br><br>');
        $v = Volontario::elenco();
        foreach($v as $_v) 
        {
            $appartenenze = $_v->numAppartenenzeTotali(MEMBRO_DIMESSO);
            if($appartenenze == 0 && !$_v->email)
            {
                $totale++;
                echo('Anagrafica ID:['.$_v->id.'] senza contatti -> provvedo alla rimozione di '.$_v->codiceFiscale.' '.$_v->nome.' '.$_v->cognome.'<br>');
                $f = TitoloPersonale::filtra([
                    ['volontario', $_v->id]
                ]);

                foreach ($f as $_f) {
                    $_f->cancella();
                }
                $_v->cancella();
            }
        }
    }

    echo('<br><strong>Sono state cancellate '.$totale.' persone</strong>');

    ?>
</code>
</pre>
