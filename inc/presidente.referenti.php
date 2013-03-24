<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPresidenziale();

?>
<script type="text/javascript"><?php require './js/admin.listaUtenti.js'; ?></script>
<?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Referente dimesso</strong>.
            Il Referente è stato dimesso con successo.
        </div>
<?php } ?>
<?php if ( isset($_GET['new']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Referente nominato</strong>.
            Il Referente è stato nominato con successo.
        </div>
<?php } ?>
<br/>
    <div class="control-group" align="right">
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-search"></i></span>
                <input required id="cercaUtente" placeholder="Cerca utente..." class="span4" type="text">
            </div>
        </div>
    </div> 
<hr />
<table class="table table-striped table-bordered" id="tabellaUtenti">
    <thead>
        <th>#</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Codice Fiscale</th>
        <th>Data di Nascita</th>
        <th>Luogo di Nascita</th>
        <th>Comitato</th>
        <th>Applicazione</th>
        <th>Dominio</th>
        <th>Azione</th>
    </thead>
<?php
foreach ( $me->comitatiDiCompetenza() as $comitato ) {

    foreach ( $comitato->delegati() as $delegato ) { 
        $_v = $delegato->volontario();
        ?>
        <tr>
            <td><?php echo $delegato->id; ?></td>
            <td><?php echo $_v->nome; ?></td>
            <td><?php echo $_v->cognome; ?></td>
            <td><?php echo $_v->codiceFiscale; ?></td>
            <td><?php echo date('d-m-Y', $_v->dataNascita); ?></td> 
            <td><?php echo $_v->comuneNascita; ?></td>
            <td><?php echo $comitato->nome; ?></td>
            <td><?php echo $conf['applicazioni'][$delegato->applicazione]; ?></td>
            <td>
                <?php if ( $delegato->applicazione == APP_ATTIVITA ) { ?>
                  Attività: <?php echo $conf['app_attivita'][$delegato->dominio]; ?>
                <?php } ?>
            </td>
            <td>
                    <a class="btn btn-danger" onClick="return confirm('Vuoi veramente dimettere questo Referente ?');" href="?p=presidente.dimettireferenti&id=<?php echo $delegato->id; ?>">
                    <i class="icon-ban-circle"></i>
                        Dimetti
                    </a>
            </td>

        </tr>
      <?php 
      
      }
      
 }


?>
 
</table>