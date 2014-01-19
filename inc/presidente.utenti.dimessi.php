<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE]);


menuElenchiVolontari(
    "Volontari dimessi",                // Nome elenco
    "?p=admin.utenti.excel&dimessi",    // Link scarica elenco
    false                               // Link email elenco
);
?>

<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Utente eliminato</strong>.
            L'utente è stato eliminato con successo.
        </div>
<?php } elseif ( isset($_GET['e']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Impossibile eliminare l'utente</h4>
            <p>Contatta l'amministratore</p>
        </div>
<?php }elseif ( isset($_GET['err']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Impossibile completare l'operazione</h4>
            <p>L'utente non è riammissibile o non hai i permessi per riammetterlo.</p>
        </div>
<?php }elseif (isset($_GET['errGen'])) { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
        <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
    </div> 
<?php } ?>
  
<div class="row-fluid">
   <div class="span12">

       <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Codice Fiscale</th>
                <th>Azioni</th>
            </thead>
        <?php
        $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $t = $comitato->membriDimessi();
                ?>
            
            <tr class="success">
                <td colspan="4" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?php echo count($t); ?>
                    </span>
                    <a class="btn btn-small pull-right" 
                       href="?p=presidente.utenti.excel&comitato=<?php echo $comitato->id; ?>&dimessi"
                       data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                    </a>
                </td>
            </tr>
            
            <?php
            foreach ( $t as $_v ) {
            ?>
                <tr>
                    <td><?php echo $_v->cognome; ?></td>
                    <td><?php echo $_v->nome; ?></td>
                    <td><?php echo $_v->codiceFiscale; ?></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $_v->id; ?>" title="Dettagli">
                                <i class="icon-eye-open"></i> Dettagli
                            </a>
                            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>" title="Invia Mail">
                                <i class="icon-envelope"></i>
                            </a>
                            <!--<?php if ($_v->riammissibile()) { ?>
                                <a class="btn btn-small btn-info" href="?p=us.utente.riammetti&id=<?php echo $_v->id; ?>" title="Riammetti socio">
                                    <i class="icon-tag"></i> Riammetti
                                </a>
                            <?php } ?>-->
                            <?php if ($me->admin()) { ?>
                                <a  onClick="return confirm('Vuoi veramente cancellare questo utente ?');" href="?p=admin.utente.cancella&id=<?php echo $_v->id; ?>" title="Cancella Utente" class="btn btn-small btn-warning">
                                <i class="icon-trash"></i> Cancella
                                </a>
                                <a class="btn btn-small btn-primary" href="?p=admin.beuser&id=<?php echo $_v->id; ?>" title="Log in">
                                    <i class="icon-key"></i>
                                </a> 
                            <?php } ?>
                        </div>
                   </td>
                </tr>
                
               
       
        <?php }
        }
        ?>

        
        </table>

    </div>
    
</div>
