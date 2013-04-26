<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-book muted"></i>
            Rubrica Referenti
        </h2>
    </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Referente..." type="text">
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
$comitati = $me->comitatiDiCompetenza();
if ( !$comitati ) { $comitati = [ $me->unComitato() ]; }
foreach ( $comitati as $comitato ) {
    foreach ( $comitato->delegati() as $delegato ) { 
        if ($delegato->applicazione != APP_PRESIDENTE){
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
                <?php switch ( $delegato->applicazione ) { 
                                case APP_ATTIVITA:
                                    ?>
                                    <strong>Referente</strong>
                                    <?php echo $conf['app_attivita'][$delegato->dominio]; ?>
                                    <?php
                                    break;
                                case APP_OBIETTIVO:
                                    ?>
                                    <strong>Delegato</strong>
                                    <?php echo $conf['obiettivi'][$delegato->dominio]; ?>
                                    <?php
                                    break;
                                    
                            } ?>
            </td>
            <td>
                    <a class="btn btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>">
                    <i class="icon-envelope"></i>
                    Invia mail
                    </a>
            </td>

        </tr>
      <?php 
      
      }
      
 }
}

?>

</table>