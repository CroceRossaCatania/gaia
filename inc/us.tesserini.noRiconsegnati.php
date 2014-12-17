<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);
?>

<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
<?php if ( isset($_GET['ok']) ) { ?>
    <div class="alert alert-success">
        <i class="icon-save"></i> <strong>Consegna tesserino registrata</strong>.
        La consegna del tesserino è stata registrata con successo.
    </div>
<?php } ?>
<?php if (isset($_GET['err'])) { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
        <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
    </div> 
<?php } ?>
<br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-credit-card muted"></i>
            Tesserini non riconsegnati
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontari..." type="text">
        </div>
    </div>    
</div>

<hr />
<table class="table table-striped table-bordered" id="tabellaUtenti">
    <thead>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Codice Fiscale</th>
        <th>Azione</th>
    </thead>
    <?php
    $comitati= $me->comitatiApp([APP_SOCI, APP_PRESIDENTE]);
    foreach($comitati as $comitato){
        foreach($comitato->tesseriniNonRiconsegnati() as $v) {
            $v = Utente::id($v);
            ?>
            <tr>
                <td><?php echo $v->nome; ?></td>
                <td><?php echo $v->cognome; ?></td>
                <td><?php echo $v->codiceFiscale; ?></td>
                <td>
                <?php 
                if($v->modificabileDa($me)) { ?> 
                    <div class="btn-group">
                        <a class="btn btn-info" href="?p=us.tesserino.riconsegna&id=<?= $v->id; ?>">
                            <i class="icon-ok"></i> Registra riconsegna
                        </a>
                    </div>
                <?php }
                    } ?>
                </td>    
            </tr>
        <?php 
    } ?>
</table>
