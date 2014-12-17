<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);
/* Funzione per cui ognuno vede i veicoli della propria sede */

?>
<?php if ( isset($_GET['new']) ) { ?>
    <div class="alert alert-success">
        <i class="icon-save"></i> <strong>Veicolo aggiunto</strong>.
        Il Veicolo è stato aggiunto con successo.
    </div>
<?php } elseif ( isset($_GET['del']) )  { ?>
    <div class="alert alert-block alert-error">
        <i class="icon-exclamation-sign"></i> <strong>Veicolo cancellato</strong>
        Il Veicolo è stato cancellato con successo.
    </div>
<?php }elseif ( isset($_GET['dup']) ) { ?>
    <div class="alert alert-error">
        <i class="icon-warning-sign"></i> <strong>Veicolo presente</strong>.
        Il Veicolo è già presente in elenco.
    </div>
<?php } elseif ( isset($_GET['mod']) )  { ?>
    <div class="alert alert-block alert-success">
        <i class="icon-edit"></i> <strong>Veicolo modificato</strong>
        Il Veicolo è stato modificato con successo.
    </div>
<?php } elseif ( isset($_GET['duplib']) ) { ?>
    <div class="alert alert-error">
        <i class="icon-warning-sign"></i> <strong>Libretto presente</strong>.
        Il libretto è già associato ad un altro veicolo presente in elenco.
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
            Veicoli fuoriuso
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
            <input autofocus required id="cercaUtente" placeholder="Cerca Veicolo fuori uso..." type="text">
        </div>
    </div>  
    <br/>
</div>

<hr />

<div class="row-fluid">
    <div class="span12">
        <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Targa</th>
                <th>Destinazione ed uso</th>
                <th>Collocazione</th>
                <th>Azioni</th>
            </thead>
            <?php
            $comitati = $me->comitatiApp ([ APP_AUTOPARCO, APP_PRESIDENTE ],false);
            foreach ( $comitati as $comitato ){
                foreach(Veicolo::filtra([['comitato', $comitato->oid()],['stato', VEI_FUORIUSO]],'targa ASC') as $veicolo){
                    ?>
                    <tr>
                        <td><?= $veicolo->targa; ?></td>
                        <td><?= $veicolo->uso; ?></td>
                        <td><?= $veicolo->collocazione(); ?></td>
                        <td>
                            <div class="btn-group">
                                <a  href="?p=autoparco.veicolo.dettagli&id=<?= $veicolo->id; ?>" title="Visualizza dettagli veicolo" class="btn btn-small">
                                    <i class="icon-eye-open"></i> Dettagli
                                </a>
                                <a  href="?p=autoparco.veicolo.manutenzione&id=<?= $veicolo->id; ?>" title="Manutenzione Veicolo" class="btn btn-small btn-success">
                                    <i class="icon-wrench"></i> Manutenzione
                                </a>
                                <a  href="?p=autoparco.veicolo.rifornimento.nuovo&id=<?= $veicolo->id; ?>" title="Rifornimento Veicolo" class="btn btn-small btn-info">
                                    <i class="icon-credit-card"></i> Rifornimento
                                </a>
                                <?php if ( $me->admin() ){ ?>
                                    <a  onClick="return confirm('Vuoi veramente cancellare questo veicolo ?');" href="?p=autoparco.veicolo.cancella&id=<?= $veicolo->id; ?>" title="Cancella Veicolo" class="btn btn-small btn-danger">
                                        <i class="icon-trash"></i> Cancella
                                    </a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } }?>
        </table>
    </div>
</div>