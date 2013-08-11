<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
$v = $_GET['id'];
$v = Volontario::by('id', $v);
$appartenenza = $v->storico();
?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span5 allinea-sinistra">
        <h2>
            <i class="icon-paperclip muted"></i>
            Quote associative
        </h2>
        <p>Volontario: <strong><?= $v->nomeCompleto(); ?></strong></p>
    </div>
            
            <div class="span3">
                <div class="btn-group btn-group-vertical span12">
                    <a href="?p=us.quoteSi" class="btn btn-block">
                        <i class="icon-reply"></i>
                        Torna indietro
                    </a>
                </div>
            </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontario..." type="text">
        </div>
    </div>    
</div>
    
<hr />
    
<div class="row-fluid">
   <div class="span12">
       
       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>N.</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Comitato</th>
                <th>Data versamento</th>
                <th>Quota</th>
                <th>Registrata da</th>
                <th>Azioni</th>
            </thead>
        <?php
foreach ( $appartenenza as $app ) { 
$q = Quota::filtra([['appartenenza', $app]], 'timestamp DESC');
    foreach ( $q as $_q ){   
                ?>
                <tr>
                    <td><?= $_q->id; ?></td>
                    <td><?= $_q->volontario()->nome; ?></td>
                    <td><?= $_q->volontario()->cognome; ?></td>
                    <td><?= $_q->comitato()->nomeCompleto(); ?></td>
                    <td><?= date('d/m/Y', $_q->timestamp); ?></td>
                    <td><?= $_q->quota ,"€"; ?></td>
                    <td><?= $_q->conferma()->nomeCompleto(); ?></td>
                    <td>
                        <a class="btn btn-small btn-info" href="?p=us.quote.ricevuta&id=<?= $_q->id; ?>" title="Invia Mail">
                            <i class="icon-paperclip"></i> Ricevuta
                        </a>
                    </td>
                </tr>
                <?php 
}
    }
?>
        </table>
    </div>
    
</div>

