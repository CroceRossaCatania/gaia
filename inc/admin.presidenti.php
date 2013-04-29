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
<br/>
    <div class="control-group" align="right">
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-search"></i></span>
                <input data-t="<?php echo $t; ?>" autofocus required id="cercaUtente" placeholder="Cerca Presidente..." class="span4" type="text">
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
        <th>Comitato Presidente</th>
        <th>Azione</th>
    </thead>
<?php
foreach ( $me->comitatiDiCompetenza() as $comitato ) { 
    foreach ( $comitato->presidenti() as $presidente ) {
        if($presidente->attuale()){
        $_v = $presidente->volontario();
        ?>
    <tr>
        <td><?php echo $_v->nome; ?></td>
        <td><?php echo $_v->cognome; ?></td>
        <td><?php echo $_v->codiceFiscale; ?></td>
        <td><?php echo date('d-m-Y', $_v->dataNascita); ?></td> 
        <td><?php echo $_v->comuneNascita; ?></td>
        <td><?php echo $comitato->nome; ?></td>
        <td>
                <a class="btn btn-danger" onClick="return confirm('Vuoi veramente dimettere questo Presidente ?');" href="?p=admin.presidente.dimetti&id=<?php echo $presidente->id; ?>">
                <i class="icon-ban-circle"></i>
                    Dimetti
                </a>
        </td>
       
    </tr>
    <?php 
    
        }}
    
}  

?>
 
</table>