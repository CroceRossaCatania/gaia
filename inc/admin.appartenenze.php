<?php


/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

set_time_limit(0);
?>
<h3><i class="icon-group muted"></i> Fix appartenenze</h3>

<code><pre>Start fix delle appartenenze negate:
    <?php
    $appartenenze = Appartenenza::filtra([['stato', MEMBRO_PENDENTE]]);
    $inizio = time();
    $numApp = 0;
    echo "<br/>";
    foreach( $appartenenze as $appartenenza ){
        if( $appartenenza->fine == 0 || $appartenenza->fine == null ){
            continue;
        }
        echo "[", $appartenenza->id, "]";
        echo " - Appartenenza corrotta", " Fine: ", $appartenenza->fine;
        $appartenenza->stato = MEMBRO_APP_NEGATA;
        echo " - Appartenenza riparata - Operazione completata!<br/>";
        $numApp++;
    }
    $fine = time();
    $ora = $fine-$inizio;
    ?>
    Ho riparato <strong><?= $numApp; ?></strong> appartenenze.
    Ho impiegato <strong><?= $ora; ?></strong> sec.
</code></pre>