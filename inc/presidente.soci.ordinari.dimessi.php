<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE ]);
menuElenchiVolontari(
    "Soci Ordinari Dimessi",
    "?p=admin.utenti.excel&ordinaridimessi",
    "?p=utente.mail.nuova&ordinaridimessicom"
);

$admin = $me->admin();

?>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Socio Ordinario eliminato</strong>.
            Il Socio Ordinario è stato eliminato con successo.
        </div>
<?php } elseif ( isset($_GET['e']) )  { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-exclamation-sign"></i> Impossibile eliminare l'utente</h4>
            <p>Contatta l'amministratore</p>
        </div>
<?php } ?>
    
<div class="row-fluid">
   <div class="span12">
        <div class="nascosto" id="azioniElenco">
            <div class="btn-group">
                <a class="btn btn-small" href="?p=presidente.utente.visualizza&id={id}" title="Dettagli" target="_new">
                    <i class="icon-eye-open"></i> Dettagli
                </a>
                <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id={id}" title="Invia Mail">
                    <i class="icon-envelope"></i>
                </a>
                <?php if($admin){ ?>
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
        data-stato="<?= MEMBRO_ORDINARIO_DIMESSO ?>"
        data-passato="true"
        data-statopersona="<?= PERSONA ?>"
        <?php if(!$me->admin()) echo("data-comitati=\"{$me->delegazioneAttuale()->comitato()->oid()}\""); ?>
        />
        </table>
       
    </div>
    
</div>
