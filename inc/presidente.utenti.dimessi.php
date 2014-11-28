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
        <div class="nascosto" id="azioniElenco">
            <div class="btn-group">
                <a class="btn btn-small" href="?p=presidente.utente.visualizza&id={id}" target="_new" title="Dettagli">
                    <i class="icon-eye-open"></i> Dettagli
                </a>
                <a class="btn btn-small btn-warning {riammissibile}" href="?p=us.utente.riammetti&id={id}" title="Riammetti">
                    <i class="icon-eye-open"></i> Riammetti
                </a>
                <?php if ($admin) { ?>
                    <a  onClick="return confirm('Vuoi veramente cancellare questo utente ?');" href="?p=admin.utente.cancella&id={id}" title="Cancella Utente" class="btn btn-small btn-warning">
                        <i class="icon-trash"></i> Cancella
                    </a>
                    <a class="btn btn-small btn-primary" href="?p=admin.beuser&id={id}" title="Log in">
                        <i class="icon-key"></i>
                    </a> 
                <?php } ?>
            </div>
        </div>
        <table
        data-volontari="elenco"
        data-perpagina="30"
        data-azioni="#azioniElenco"
        data-passato="true"
        data-stato="<?= MEMBRO_DIMESSO ?>"
        data-statopersona="<?= PERSONA ?>"
        <?php if(!$me->admin()) echo("data-comitati=\"{$me->delegazioneAttuale()->comitato()->oid()}\""); ?>
        >
        </table>


    </div>
    
</div>
