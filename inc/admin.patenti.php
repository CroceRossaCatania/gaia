<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
set_time_limit(0);
?>
<div class="row-fluid">
    <div class="span4 allinea-sinistra">
        <h2>
            <i class="icon-truck muted"></i>
            Conversione patenti
        </h2>
    </div>  
    <div class="span4">
        <a href="?p=admin.script" class="btn btn-block">
            <i class="icon-reply"></i>
            Torna indietro
        </a>
    </div>  
</div>
<code>
    <pre>Avvio conversione...
    <?php
    $patenti = Patente::patentiTitoli();
    $i=0;
    foreach ( $patenti as $patente ){
        $volontario = $patente->volontario;
        $esiste = Utente::by('id', $volontario);
        if(!$esiste){ continue; }
        echo "[",$i,"]"," - ", $patente->volontario()->nomeCompleto(), " - ", $patente->titolo()->nome , "<br/>";
        $pat = Patente::by('volontario', $volontario);
        if (!$pat) {
            $p = new Patente();
            $p->tipo = PATENTE_CRI;
            $p->volontario = $volontario;
            $p->codice = $patente->codice;
            $p->tConferma = $patente->tConferma;
            $p->pConferma = $patente->pConferma;
            $p->inizio = $patente->inizio;
            $p->fine = $patente->fine;
        } else {
            $p = Patente::id($pat);
        }
        /* Categorie */
        $i++;
    }
    ?>
Ho convertito <?= $i; ?> patenti.
</pre></code>
