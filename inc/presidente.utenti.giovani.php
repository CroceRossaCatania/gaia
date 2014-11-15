<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE, APP_OBIETTIVO ]);
menuElenchiVolontari(
    "Volontari giovani",
    "?p=admin.utenti.excel&giovani",
    "?p=utente.mail.nuova&comgio"
);

$admin = (bool) $me->admin();

$d = $me->delegazioneAttuale();

?>
<?php if ( isset($_GET['ok']) ) { ?>
    <div class="alert alert-success">
        <i class="icon-save"></i> <strong>Volontario eliminato</strong>.
        Il Volontario è stato eliminato con successo.
    </div>
<?php } elseif ( isset($_GET['e']) )  { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-exclamation-sign"></i> Impossibile eliminare l'utente</h4>
        <p>Contatta l'amministratore</p>
    </div>
<?php }elseif ( isset($_GET['dim']) )  { ?>
    <div class="alert alert-block alert-success">
        <h4><i class="icon-exclamation-sign"></i> Volontario dimesso</h4>
        <p>Il Volontario è stato dimesso con successo.</p>
    </div>
<?php } ?>
    
<div class="row-fluid">
   <div class="span12">  
        <div class="nascosto" id="azioniElenco">
            <div class="btn-group">
                <?php if ( $d->dominio == 5 ){ ?>
                    <a class="btn btn-small" href="?p=profilo.controllo&id={id}" target="_new" title="Dettagli">
                        <i class="icon-eye-open"></i> Dettagli
                    </a>
                <?php }else{ ?>
                    <a class="btn btn-small" href="?p=presidente.utente.visualizza&id={id}" target="_new" title="Dettagli">
                        <i class="icon-eye-open"></i> Dettagli
                    </a>
                <?php } ?>
                <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id={id}" title="Invia Mail">
                    <i class="icon-envelope"></i>
                </a>
                <?php if ($admin) { ?>
                <a  onClick="return confirm('Vuoi veramente cancellare questo utente ?');" href="?p=admin.utente.cancella&id={id}" title="Cancella Utente" class="btn btn-small btn-warning">
                    <i class="icon-trash"></i> Cancella
                </a>
                <a class="btn btn-small btn-primary" href="?p=admin.beuser&id={id}" title="Log in">
                    <i class="icon-key"></i>
                </a> 
                <a class="btn btn-small btn-primary" href="?p=admin.password.nuova&id={id}" title="Cambia password">
                    <i class="icon-eraser"></i>
                </a>
                <a class="btn btn-small btn-primary" href="?p=admin.password.reset&id={id}" title="Esegui reset password">
                    <i class="icon-flag-checkered"></i>
                </a>                
                <a class="btn btn-small btn-primary" href="?p=admin.presidente.nuovo&id={id}" title="Nomina Presidente">
                    <i class="icon-star"></i>
                </a> 
                <a class="btn btn-small btn-danger" href="?p=admin.admin.nuovo&id={id}" title="Nomina Admin">
                    <i class="icon-magic"></i>
                </a>
                <?php } ?>
            </div>
        </div>
        <table
        data-volontari="elenco"
        data-perpagina="30"
        data-azioni="#azioniElenco"
        data-giovane="true"
        <?php if(!$me->admin) echo("data-comitati=\"{$me->delegazioneAttuale()->comitato()->oid()}\""); ?>
        >
        </table>
    
    </div>
</div>