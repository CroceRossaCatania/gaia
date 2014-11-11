<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

?>
<?php if ( isset($_GET['new']) ) { ?>
    <div class="alert alert-success">
        <i class="icon-save"></i> <strong>Autoparco aggiunto</strong>.
        L'Autoparco è stato aggiunto con successo.
    </div>
<?php } elseif ( isset($_GET['del']) )  { ?>
    <div class="alert alert-block alert-error">
        <i class="icon-exclamation-sign"></i> <strong>Autoparco cancellato</strong>
        L'Autoparco è stato cancellato con successo.
    </div>
<?php } ?>
<?php if (isset($_GET['err'])) { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
        <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
    </div> 
<?php } ?>
<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span4">
        <h2>
            <i class="icon-truck muted"></i>
            Elenco Autoparchi
        </h2>
    </div>

    <div class="span4">
        <div class="btn-group btn-group-vertical span12">
            <a href="?p=autoparco.dash" class="btn btn-block ">
                <i class="icon-reply"></i> Torna alla dash
            </a>
        </div>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Autoparco..." type="text">
        </div>
        <!-- può usarlo solo presidente o delegato di comitato e non di unità territoriale -->
        <a class="btn btn-success" href="?p=autoparco.nuovo">
            <i class="icon-plus"></i> Aggiungi Autoparco
        </a>
    </div>  
    <br/>
</div>

<hr />

<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Nome</th>
                <th>Localizzazione</th>
                <th>Unità territoriale</th>
                <th>Azioni</th>
            </thead>
            <?php
            $comitati = $me->comitatiApp([APP_PRESIDENTE,APP_AUTOPARCO],false);
            foreach ( $comitati as $comitato ){
                foreach(Autoparco::filtra([['comitato', $comitato->oid()]],'nome ASC') as $autoparco){
                    ?>
                    <tr>
                        <td><?= $autoparco->nome; ?></td>
                        <td><?= $autoparco->formattato; ?></td>
                        <td><?= $comitato->nome; ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="?p=autoparco.dettagli&id=<?= $autoparco->id; ?>" title="Visualizza dettagli autoparco" class="btn btn-small">
                                    <i class="icon-eye-open"></i> Dettagli
                                </a>
                                <a  onClick="return confirm('Vuoi veramente cancellare questo autoparco ?');" href="?p=autoparco.cancella&id=<?= $autoparco->id; ?>" title="Cancella autoparco" class="btn btn-small btn-danger">
                                    <i class="icon-trash"></i> Cancella
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } }?>
        </table>
    </div>
</div>