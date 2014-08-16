    <?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>
<script type="text/javascript"><?php require './assets/js/presidente.utenti.js'; ?></script>
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
        <th>Cellulare</th>
        <th>Email</th>
        <th>Comitato Delegato</th>
        <th>Area</th>
    </thead>
<?php

/*
 * Ottengo elenco dei delegati.
 */
$delegati = Delegato::filtra([
    ['applicazione', APP_OBIETTIVO]
]);

foreach ( $delegati as $delegato ) {
    
    // Ignoro i delegati non più attuali
    if ( !$delegato->attuale() ) { continue; }
    
    // Carico il volontario in memoria
    $_v = $delegato->volontario();
    
    ?>
<tr>
    <td><strong><?php echo $_v->nome; ?></strong></td>
    <td><strong><?php echo $_v->cognome; ?></strong></td>
    <td><?php echo $_v->cellulare; ?></td>
    <td><?php echo $_v->email; ?></td> 
    <td><?php echo $delegato->comitato()->nomeCompleto(); ?></td>
    <td><?php echo (''.$delegato->dominio.' '.$conf['nomiobiettivi'][$delegato->dominio]); ?></td>
</tr>
<?php 

    }


?>
 
</table>
