<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE ]);

menuElenchiVolontari(
    "Volontari attivi",
    "?p=admin.utenti.excel",
    "?p=utente.mail.nuova&com"
);

?>

<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Volontario eliminato</strong>.
            Il Volontario è stato eliminato con successo.
        </div>
<?php }elseif ( isset($_GET['dim']) )  { ?>
        <div class="alert alert-block alert-success">
            <h4><i class="icon-exclamation-sign"></i> Volontario dimesso</h4>
            <p>Il Volontario è stato dimesso con successo.</p>
        </div>
<?php } ?>
    
<div class="row-fluid">

    <div class="nascosto" id="azioniElenco">
        <div class="btn-group">
            <a class="btn btn-small" href="?p=presidente.utente.visualizza&id={id}" target="_new" title="Dettagli">
                <i class="icon-eye-open"></i> Dettagli
            </a>
            <a class="btn btn-small btn-info" href="?p=us.tesserini.p&id={id}" title="Stampa tesserino">
                    <i class="icon-barcode"></i> Tesserino
            </a>
            <a class="btn btn-small btn-danger" href="?p=presidente.utente.dimetti&id={id}" title="Dimetti Volontario">
                    <i class="icon-ban-circle"></i> Dimetti
            </a>
            <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id={id}" title="Invia Mail">
                <i class="icon-envelope"></i>
            </a>
            <?php if ($me->admin) { ?>
                <a  onClick="return confirm('Vuoi veramente cancellare questo utente ?');" href="?p=presidente.utente.cancella&id={id}" title="Cancella Utente" class="btn btn-small btn-warning">
                    <i class="icon-trash"></i> Cancella
                </a>
                <a class="btn btn-small btn-primary" href="?p=admin.beuser&id={id}" title="Log in">
                    <i class="icon-key"></i>
                </a> 
                <a class="btn btn-small btn-primary" href="?p=admin.password.nuova&id={id}" title="Cambia password">
                    <i class="icon-eraser"></i>
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
        >
    </table>

</div>
