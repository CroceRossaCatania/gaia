<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>
<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
<?php if ( isset($_GET['ok']) ) { ?>
<div class="alert alert-success">
    <i class="icon-save"></i> <strong>Amministrazione revocata</strong>.
    L'utente ha perso l'amministrazione.
</div>
<?php } ?>
<?php if ( isset($_GET['new']) ) { ?>
<div class="alert alert-success">
    <i class="icon-save"></i> <strong>Amministratore nominato</strong>.
    L'amministratore è stato nominato con successo.
</div>
<?php } ?>
<br/>
<div class="row-fluid">
    <div class="span6 allinea-sinistra">
        <h2>
            <i class="icon-star muted"></i>
            Elenco Admin
        </h2>
    </div>
    
    <div class="span6 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Admin..." type="text">
        </div>
    </div>    
</div>
<hr />
<table class="table table-striped table-bordered" id="tabellaUtenti">
    <thead>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Codice Fiscale</th>
        <th>Data di Nascita</th>
        <th>Luogo di Nascita</th>
        <th>Azione</th>
    </thead>
    <?php
    foreach ( Utente::listaAdmin() as $_v ) {  ?>
    <tr>
        <td><?php echo $_v->nome; ?></td>
        <td><?php echo $_v->cognome; ?></td>
        <td><?php echo $_v->codiceFiscale; ?></td>
        <td><?php echo date('d-m-Y', $_v->dataNascita); ?></td> 
        <td><?php echo $_v->comuneNascita; ?></td>
        <td>
            <a class="btn btn-danger btn-small" onClick="return confirm('Vuoi veramente revocare amministrazione a questo utente ?');" href="?p=admin.admin.dimetti&id=<?php echo $_v->id; ?>">
                <i class="icon-ban-circle"></i>
                Revoca
            </a>
        </td>
    </tr>
    <?php } ?>
</table>