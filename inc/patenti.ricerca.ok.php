<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_PATENTI , APP_PRESIDENTE]);

$numero = $_GET['inputNumero'];
$patenti = TitoloPersonale::filtra([['codice', $numero]]);

?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span5 allinea-sinistra">
        <h2>
            <i class="icon-search muted"></i>
            Patente
        </h2>
    </div>
            
            <div class="span3">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=patenti.dash" class="btn btn-block">
                        <i class="icon-reply"></i>
                        Torna alla dash
                    </a>
                </div>
            </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontari..." type="text">
        </div>
    </div>    
</div>
    
<hr />
    
<div class="row-fluid">
   <div class="span12">
       
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Numero Patente</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Comitato</th>
                <th>Categoria</th>
                <th>Data Emissione</th>
                <th>Data Scadenza</th>
            </thead>
        <?php
        foreach($patenti as $patente){
                ?>
                <tr>
                    <td><?= $numero; ?></td>
                    <td><?= $patente->volontario()->nome; ?></td>
                    <td><?= $patente->volontario()->cognome; ?></td>
                    <td><?= $patente->volontario()->unComitato()->nomeCompleto(); ?></td>
                    <td><?= $patente->titolo()->nome; ?></td>
                    <td><?= date('d/m/Y', $patente->inizio); ?></td>
                    <td><?= date('d/m/Y', $patente->fine);  ?></td>
                </tr>
               <?php } ?> 
        </table>
       
    </div>
    
</div>
