<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaApp([APP_SOCI , APP_PRESIDENTE ]);
menuElenchiVolontari(
    "Soci Ordinari",
    "?p=admin.utenti.excel&ordinari",
    "?p=utente.mail.nuova&ordinaricom"
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
<?php }elseif ( isset($_GET['dim']) )  { ?>
    <div class="alert alert-block alert-success">
        <h4><i class="icon-exclamation-sign"></i> Socio Ordinario dimesso</h4>
        <p>Il Socio Ordinario è stato dimesso con successo.</p>
    </div>
<?php }elseif ( isset($_GET['iscritto']) )  { ?>
    <div class="alert alert-block alert-success">
        <h4><i class="icon-exclamation-sign"></i> Socio Ordinario iscritto al corso base</h4>
        <p>Il Socio Ordinario è iscritto con successo al corso base.</p>
    </div>
<?php }elseif ( isset($_GET['err']) )  { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-warning-sign"></i> Qualcosa non ha funzionato</h4>
        <p>L'operazione che hai tentato di eseguire non è andata a buon fine, riprova per favore.</p>
    </div>
<?php }elseif ( isset($_GET['noCorsi']) )  { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-warning-sign"></i> Nessun corso base attivo</h4>
        <p>Al momento non ci sono corsi base attivi sul comitato e sulle unità territoriali.</p>
    </div>
<?php } elseif (isset($_GET['tesgia'])) { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-exclamation-sign"></i> Richiesta già effettuata</h4>
        <p>Non è possibile effettuare più richieste di tesserino per lo stesso volontario.</p>
    </div>
<?php }elseif ( isset($_GET['gia']) )  { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-warning-sign"></i> Il volontario risulta già iscritto</h4>
        <p>Il volontario che hai selezionato risulta già iscritto ad un corso base.</p>
    </div>
<?php } elseif (isset($_GET['tok'])) { ?>
    <div class="alert alert-block alert-success">
        <h4><i class="icon-exclamation-sign"></i> Richiesta effettuata con successo</h4>
        <p>La tua richiesta di stampa del tesserino è stata correttamente presa in carico.</p>
    </div>
<?php } elseif (isset($_GET['tdupko'])) { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-exclamation-sign"></i> Impossibile richiedere duplicato</h4>
        <p>La tua richiesta di duplicato del tesserino non è stata presa in caricoin quanto non esiste un tesserino da duplicare.</p>
    </div>
<?php } elseif (isset($_GET['tdupok'])) { ?>
    <div class="alert alert-block alert-success">
        <h4><i class="icon-exclamation-sign"></i> Richiesta duplicato effettuata con successo</h4>
        <p>La tua richiesta di stampa del duplicato del tesserino è stata correttamente presa in carico.</p>
    </div>
<?php } ?>
    
<div class="row-fluid">
   <div class="span12">
        <div class="nascosto" id="azioniElenco">     
            <div class="btn-group">
                <a class="btn btn-small" href="?p=presidente.utente.visualizza&id={id}" title="Dettagli" target="_new">
                    <i class="icon-eye-open"></i> Dettagli
                </a> 
                <a class="btn btn-small btn-info {iscriviBase}" href="?p=formazione.corsibase.iscrizione.ordinario&id={id}" title="Iscrivi a corso base">
                    <i class="icon-flag"></i> Iscrivi a corso
                </a> 
                <a class="btn btn-small btn-danger" href="?p=presidente.utente.dimetti&ordinario&id={id}" title="Dimetti Volontario">
                    <i class="icon-ban-circle"></i> Dimetti
                </a>
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
                <?php } ?>
            </div>
        </div>
        <table
        data-volontari="elenco"
        data-perpagina="30"
        data-azioni="#azioniElenco"
        data-stato="<?= MEMBRO_ORDINARIO ?>"
        <?php if(!$me->admin()) echo("data-comitati=\"{$me->delegazioneAttuale()->comitato()->oid()}\""); ?>
        />
        </table>
    </div>
</div>
