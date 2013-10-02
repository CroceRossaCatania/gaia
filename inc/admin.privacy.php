<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
set_time_limit(0);
$inizio = time();
?>
<div class="row-fluid">
    <div class="span4 allinea-sinistra">
        <h2>
            <i class="icon-time muted"></i>
            Popolamento privacy
        </h2>
    </div>  
    <div class="span4">
        <a href="?p=admin.script" class="btn btn-block">
            <i class="icon-reply"></i>
            Torna indietro
        </a>
    </div>  
</div>

<code><pre>Reset dei consensi: 
<?php
$utenti = Utente::elenco();
$i=0;
foreach ( $utenti as $utente ){
    $p = new Privacy();
    $p->volontario      = $utente;
    $p->mailphone       = PRIVACY_COMITATO;
    $p->mess            = PRIVACY_COMITATO;
    $p->curriculum      = PRIVACY_COMITATO;
    $p->incarichi       = PRIVACY_COMITATO;
    $p->timestamp       = time();
    echo "[",$i,"]"," - ", $utente->nomeCompleto(),"<br/>";
    $i++;
}
$fine = time();
$time = $fine - $inizio;
?>
Popolate: <strong><?php echo $i; ?></strong> impostazioni di privacy.
Ho impiegato: <strong><?php echo $time; ?></strong> secondi.
</pre></code>
