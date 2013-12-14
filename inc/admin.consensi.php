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
            <i class="icon-time muted"></i>
            Reset consensi
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
    echo "[",$i,"]"," - ";
    echo $utente->nomeCompleto(), " - ", date('d/m/Y', $utente->consenso),"<br/>";
    $utente->consenso = null;
    $i++;
}
?>
Resettati: <strong><?php echo $i; ?></strong> consensi.
</pre></code>
