<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([ APP_OBIETTIVO , APP_PRESIDENTE , APP_SOCI ]);
$f= new Titolo($_POST['idTitolo']);
?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span8">
        <h3>
            <i class="icon-search muted"></i>
            Ricerca volontari per titolo
        </h3>
        <p>Titolo cercato: <strong><?= $f->nome; ?></strong>
        <a class="btn btn-small" href="?p=presidente.titoli.ricerca"><i class="icon-pencil"></i> Modifica titolo</a></p>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontario..." type="text">
        </div>
    </div>    
</div>
    
<div class="row-fluid">
    <div class="btn-group btn-group-vertical span12">
        <a href="?p=admin.utenti.excel&mass&t=<?= $_POST['idTitolo']; ?>" class="btn btn-block btn-inverse" data-attendere="Generazione e compressione in corso...">
           <i class="icon-download"></i>
            Scarica questo elenco in format excel
       </a>
        <a href="?p=utente.mail.nuova&mass&t=<?= $_POST['idTitolo']; ?>" class="btn btn-block btn-success">
            <i class="icon-envelope"></i>
             Invia mail di massa a tutti i Volontari con questo titolo
        </a>
   </div>
</div>

<hr />
<table class="table table-striped table-bordered" id="tabellaUtenti">
    <thead>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Data di Nascita</th>
        <th>Azioni</th>
    </thead>
<?php
  foreach($me->comitatiApp ([ APP_SOCI , APP_PRESIDENTE , APP_OBIETTIVO ]) as $elenco){
      $volontari =  $elenco->ricercaMembriTitoli([$f]);  
      ?>
      <tr class="success">
                <td colspan="7" class="grassetto">
                    <?= $elenco->nomeCompleto(); ?>
                    <span class="label label-warning">
                          <?= count($volontari); ?>
                    </span>
                </td>
            </tr>
<?php 
             foreach($volontari as $volontario){?> 
            <tr>
                <td><?= $volontario->nome; ?></td>
                <td><?= $volontario->cognome; ?></td>
                <td><?= date('d-m-Y', $volontario->dataNascita); ?></td>
                <td>    
                    <a class="btn btn-success" href="?p=utente.mail.nuova&id=<?= $volontario->id; ?>">
                    <i class="icon-envelope"></i>
                    Invia mail
                    </a>
                </td>
            </tr>
<?php }} ?>
</table>
