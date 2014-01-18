<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

controllaParametri(array('inputNumero','inputAnno'), 'us.dash&err');

$numero = $_GET['inputNumero'];
$anno   = $_GET['inputAnno'];
$q = Quota::filtra([['anno', $anno],['progressivo', $numero]]);
$q = $q[0];
?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span5 allinea-sinistra">
        <h2>
            <i class="icon-search muted"></i>
            Quote associative
        </h2>
    </div>
            
            <div class="span3">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=us.dash" class="btn btn-block">
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
                <th>Id quota</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Comitato</th>
                <th>Data versamento</th>
                <th>Quota</th>
                <th>Azioni</th>
            </thead>
        <?php
        $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
                ?>
                <tr>
                    <td><?php echo $numero; ?></td>
                    <td><?php echo $q->volontario()->nome; ?></td>
                    <td><?php echo $q->volontario()->cognome; ?></td>
                    <td><?php echo $q->comitato()->nomeCompleto(); ?></td>
                    <td><?php echo date('d/m/Y', $q->timestamp); ?></td>
                    <td><?php echo $q->quota ,"€"; ?></td>
                    <td>
                        <a class="btn btn-small btn-info" href="?p=us.quote.visualizza&id=<?php echo $q->volontario()->id; ?>" title="Visualizza ricevute">
                            <i class="icon-paperclip"></i> Ricevute
                        </a>
                    </td>
                </tr>
                
        </table>
       
    </div>
    
</div>
