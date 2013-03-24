<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

?>
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
        <th>Nome</th>
        <th>Cognome</th>
        <th>Cellulare</th>
        <th>Cellulare Servizio</th>
        <th>Email</th>
        <th>Comitato</th>
        <th>Referente</th>
        <th>Azione</th>
    </thead>
<?php
foreach ( $me->comitatiDiCompetenza() as $comitato ) {

    foreach ( $comitato->delegati() as $delegato ) { 
        $_v = $delegato->volontario();
        ?>
        <tr>
            <td><?php echo $_v->nome; ?></td>
            <td><?php echo $_v->cognome; ?></td>
            <td><?php echo $_v->cellulare; ?></td>
            <td><?php echo $_v->cellulareServizio; ?></td>
            <td><?php echo $_v->email; ?></td>
            <td><?php echo $comitato->nome; ?></td>
            <td>
                <?php if ( $delegato->applicazione == APP_ATTIVITA ) { ?>
                  Attività: <?php echo $conf['app_attivita'][$delegato->dominio]; ?>
                <?php } ?>
            </td>
            <td>
                    <a class="btn btn-success" href="?p=admin.inviaMail&id=<?php echo $_v->id; ?>">
                    <i class="icon-envelope"></i>
                    Invia mail
                    </a>
            </td>

        </tr>
      <?php 
      
      }
      
 }


?>
 
</table>