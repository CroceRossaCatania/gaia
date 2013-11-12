<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<div class="row-fluid">
    <div class="span6 allinea-sinistra">
        <h2>
            <i class="icon-list muted"></i>
            Elenco Delegati
        </h2>
    </div>
    
    <div class="span6 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Delegato..." type="text">
        </div>
    </div>    
</div>
<hr />
<a href="?p=admin.mail.nuova" class="btn btn-block btn-success">
    <i class="icon-envelope"></i>
    <strong>Admin</strong> &mdash; Invia mail di massa a tutti i Delegati.
</a>
<hr />
<table class="table table-striped table-condensed table-bordered" id="tabellaUtenti">
    <thead>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Codice Fiscale</th>
        <th>Data di Nascita</th>
        <th>Luogo di Nascita</th>
        <th>Comitato Delegato</th>
    </thead>
<?php

/*
 * Ottengo elenco dei presidenti.
 */
$delegati = Delegato::filtra([
    ['applicazione', APP_OBIETTIVO]
]);

foreach ( $delegati as $delegato ) {
    
    // Ignoro i presidenti non più attuali
    if ( !$delegato->attuale() ) { continue; }
    
    // Carico il volontario in memoria
    $_v = $delegato->volontario();
    
    ?>
<tr>
    <td><strong><?php echo $_v->nome; ?></strong></td>
    <td><strong><?php echo $_v->cognome; ?></strong></td>
    <td><?php echo $_v->codiceFiscale; ?></td>
    <td><?php echo date('d-m-Y', $_v->dataNascita); ?></td> 
    <td><?php echo $_v->comuneNascita; ?></td>
    <td><strong><?php echo $delegato->comitato()->nomeCompleto(); ?></strong></td>

</tr>
<?php 

    }


?>
 
</table>