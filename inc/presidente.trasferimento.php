<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);
?>

<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<?php if ( isset($_GET['ok']) ) { ?>
<div class="alert alert-success">
    <i class="icon-save"></i> <strong>Trasferimento Approvato</strong>.
    Trasferimento approvato con successo.
</div>
<?php } ?>
<?php if ( isset($_GET['canc']) ) { ?>
<div class="alert alert-success">
    <i class="icon-save"></i> <strong>Trasferimento cancellato</strong>.
    Il trasferimento e l'appartenenza associata sono stati cancellati.
</div>
<?php } ?>
<?php if ( isset($_GET['no']) ) { ?>
<div class="alert alert-error">
    <i class="icon-warning-sign"></i> <strong>Trasferimento negato</strong>.
    Trasferimento negato.
</div>
<?php } ?>
<?php if ( isset($_GET['prot']) ) { ?>
<div class="alert alert-info">
    <i class="icon-save"></i> <strong>Richiesta Protocollata</strong>.
    Richiesta di trasferimento protocollata con successo.
</div>
<?php } ?>
<?php if (isset($_GET['err'])) { ?>
<div class="alert alert-block alert-error">
    <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
    <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
</div> 
<?php } if (isset($_GET['giaprot'])) { ?>
<div class="alert alert-block alert-error">
    <h4><i class="icon-warning-sign"></i> <strong>Richiesta già protocollata</strong>.</h4>
    <p>Non è possibile riprotocollare la stessa richiesta più volte.</p>
</div> 
<?php } ?>
<br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-cogs muted"></i>
            Trasferimenti in attesa
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
        <th>Data Richiesta</th>
        <th>Comitato destinazione</th>
        <th>Azione</th>
    </thead>
    <?php
    $comitati= $me->comitatiApp([APP_SOCI, APP_PRESIDENTE]);
    foreach($comitati as $comitato){
        $t = Trasferimento::filtra([['stato', TRASF_INCORSO], ['cProvenienza', $comitato->id]]);
        foreach($t as $_t) {
            $v = $_t->volontario();
            ?>
            <tr>
                <td><?php echo $v->nome; ?></td>
                <td><?php echo $v->cognome; ?></td>
                <td><?php echo $v->codiceFiscale; ?></td>
                <td><?php echo date('d/m/Y', $_t->timestamp); ?></td> 
                <td><?php echo $_t->comitato()->nomeCompleto(); ?></td>
                <td>
                <?php 
                if($v->modificabileDa($me)) {
                    if($_t->protNumero){ 
                        if($me->presidenziante()) { ?>
                        <div class="btn-group">
                            <a class="btn btn-success" href="?p=presidente.trasferimento.ok&id=<?php echo $_t->id; ?>&si">
                                <i class="icon-ok"></i> Conferma
                            </a>
                            <a class="btn btn-danger" onClick="return confirm('Vuoi veramente negare il trasferimento a questo utente ?');" href="?p=presidente.trasferimentoNegato&id=<?php echo $_t->id; ?>">
                                <i class="icon-ban-circle"></i> Nega
                            </a>
                        </div>
                        <?php } else { ?>
                        In attesa di autorizzazione da parte del Presidente
                    <?php }
                    } else{ ?>  
                        <div class="btn-group">
                            <a class="btn btn-info" href="?p=presidente.trasferimentoRichiesta.stampa&id=<?php echo $_t->id; ?>">
                                <i class="icon-print"></i> Stampa richiesta
                            </a>
                            <a class="btn btn-success" href="?p=presidente.trasferimentoRichiesta&id=<?php echo $_t->id; ?>">
                                <i class="icon-ok"></i> Protocolla richiesta
                            </a>
                            <?php if ($me->admin()) { ?>
                            <a class="btn btn-danger" href="?p=admin.trasferimento.cancella&id=<?php echo $_t->id; ?>">
                                <i class="icon-trash"></i> 
                            </a>
                            <?php } ?>
                        </div>
                    <?php }
                    } ?>
                </td>    
            </tr>
        <?php }
    } ?>
</table>
