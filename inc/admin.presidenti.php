<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<?php if ( isset($_GET['ok']) ) { ?>
    <div class="alert alert-success">
        <i class="icon-save"></i> <strong>Presidente dimesso</strong>.
        Il presidente è stato dimesso con successo.
    </div>
<?php } ?>
<?php if ( isset($_GET['duplicato']) ) { ?>
    <div class="alert alert-warning">
        <i class="icon-warning-sign"></i> <strong>Il comitato ha già un presidente</strong>.
        Dimettere prima il presidente del comitato.
    </div>
<?php } ?>
<?php if ( isset($_GET['new']) ) { ?>
    <div class="alert alert-success">
        <i class="icon-save"></i> <strong>Presidente nominato</strong>.
        Il presidente è stato nominato con successo.
    </div>
<?php } ?>
<?php if (isset($_GET['err'])) { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
        <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
    </div> 
<?php } ?>
<br/>
<div class="row-fluid">
    <div class="span6 allinea-sinistra">
        <h2>
            <i class="icon-list muted"></i>
            Elenco Presidenti
        </h2>
    </div>
    
    <div class="span6 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Presidente..." type="text">
        </div>
    </div>    
</div>
<hr />
<a href="?p=admin.mail.nuova&pres" class="btn btn-block btn-success">
    <i class="icon-envelope"></i>
    <strong>Admin</strong> &mdash; Invia mail di massa a tutti i Presidenti.
</a>
<hr />
<table class="table table-striped table-condensed table-bordered" id="tabellaUtenti">
    <thead>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Codice Fiscale</th>
        <th>Data di Nascita</th>
        <th>Luogo di Nascita</th>
        <th>Comitato Presidente</th>
        <th>Estensione</th>
        <th>Azione</th>
    </thead>
    <?php

/*
 * Ottengo elenco dei presidenti.
 */
$presidenti = Delegato::filtra([
    ['applicazione', APP_PRESIDENTE]
    ]);

foreach ( $presidenti as $presidente ) {
    
    // Ignoro i presidenti non più attuali
    if ( !$presidente->attuale() ) { continue; }
    
    // Carico il volontario in memoria
    $_v = $presidente->volontario();
    
    ?>
    <tr>
        <td><strong><?php echo $_v->nome; ?></strong></td>
        <td><strong><?php echo $_v->cognome; ?></strong></td>
        <td><?php echo $_v->codiceFiscale; ?></td>
        <td><?php echo date('d-m-Y', $_v->dataNascita); ?></td> 
        <td><?php echo $_v->comuneNascita; ?></td>
        <td><strong><?php echo $presidente->comitato()->nomeCompleto(); ?></strong></td>
        <td><strong><?php echo $conf['est_obj'][$presidente->comitato()->_estensione()]; ?></strong></td>
        <td>
            <a class="btn btn-danger btn-mini" onClick="return confirm('Vuoi veramente dimettere <?php echo addslashes($_v->nomeCompleto()); ?> da presidente?');" href="?p=admin.presidente.dimetti&id=<?php echo $presidente->id; ?>">
                Dimetti
            </a>
            <a class="btn btn-danger btn-mini" onClick="return confirm('Vuoi veramente cancellare <?php echo addslashes($_v->nomeCompleto()); ?> da presidente?');" href="?p=admin.presidente.cancella&id=<?php echo $presidente->id; ?>">
                Cancella
            </a>
        </td>

    </tr>
    <?php 

}


?>

</table>