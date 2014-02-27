<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE]);


menuElenchiVolontari(
    "Volontari trasferiti",                // Nome elenco
    "?p=admin.utenti.excel&trasferiti",    // Link scarica elenco
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
                <th>Socio dal</th>
                <th>Socio fino</th>
                <th>Comitato trasferimento</th>
                <th></th>
            </thead>
        <?php
        $elenco = $me->comitatiApp ([ APP_SOCI, APP_PRESIDENTE ]);
        foreach($elenco as $comitato) {
            $t = $comitato->membriTrasferiti();
                ?>
            
            <tr class="success">
                <td colspan="6" class="grassetto">
                    <?php echo $comitato->nomeCompleto(); ?>
                    <span class="label label-warning">
                        <?php echo count($t); ?>
                    </span>
                    <a class="btn btn-small pull-right" 
                       href="?p=presidente.utenti.excel&comitato=<?php echo $comitato->id; ?>&trasferiti"
                       data-attendere="Generazione...">
                            <i class="icon-download"></i> scarica come foglio excel
                    </a>
                </td>
            </tr>
            
            <?php
            foreach ( $t as $_t ) {
                $v = $_t->volontario();
                $a = Appartenenza::filtra([
                        ['comitato', $_t->provenienza()],
                        ['stato', MEMBRO_TRASFERITO]
                    ]); 
                $a = $a[0];
             ?>
                <tr>
                    <td><?php echo $v->cognome; ?></td>
                    <td><?php echo $v->nome; ?></td>
                    <td><?php echo $v->codiceFiscale; ?></td>
                    <td><?php echo date('d/m/Y', $a->inizio); ?></td>
                    <td><?php echo date('d/m/Y', $_t->appartenenza()->inizio); ?></td>
                    <td><?php echo $_t->comitato()->nomeCompleto(); ?></td>
                </tr>  
       
        <?php }
        }
        ?>
        
        </table>

    </div>
    
</div>
