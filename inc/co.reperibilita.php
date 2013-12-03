<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_CO , APP_PRESIDENTE , APP_OBIETTIVO]);

?>

<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span5 allinea-sinistra">
            <h2>
                <i class="icon-thumbs-up muted"></i>
                Reperibilità
            </h2>
        </div>

    <div class="span3">
            <div class="btn-group btn-group-vertical span12">
                <?php if ( $me->delegazioni(APP_OBIETTIVO) ){ ?>
                    <a href="?p=obiettivo.dash" class="btn btn-block ">
                <?php }else{ ?>
                    <a href="?p=co.dash" class="btn btn-block ">
                <?php } ?>
                        <i class="icon-reply"></i> Torna alla dash
                    </a>
            </div>
        </div>

    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontari e Attività..." type="text">
        </div>
    </div> 
</div>
<hr />
<table class="table table-striped table-bordered" id="tabellaUtenti">
    <thead>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Inizio</th>
        <th>Fine</th>
        <th>Tempo Attivazione</th>
        <th>Comitato</th>
        <th>Cellulare</th>
        <th>Azione</th>
    </thead>
<?php
$comitati= $me->comitatiApp ([ APP_CO, APP_PRESIDENTE , APP_OBIETTIVO ]);
foreach($comitati as $comitato){
    foreach($comitato->reperibili() as $_t){
        $_v = $_t->volontario();
 ?>
    <tr<?php if ($_t->attuale()) { ?> class="success"<?php } ?>>
        <?php if ($_t->attuale()) { ?>
        <td><?php echo $_v->nome; ?></td>
        <td><?php echo $_v->cognome; ?></td>
        <td><?php echo date('d-m-Y H:i', $_t->inizio); ?></td>
        <td><?php echo date('d-m-Y H:i', $_t->fine); ?></td>
        <td><?php echo $_t->attivazione; ?> min</td>
        <td><?php echo $_t->comitato()->nomeCompleto(); ?></td>
        <td><?php echo $_v->cellulare; ?></td>
        <td>     
            <div class="btn-group">
                <a class="btn" href="?p=profilo.controllo&id=<?php echo $_v->id; ?>" target="_new">
                        <i class="icon-eye-open"></i>
                            Visualizza
                </a>
                <a class="btn btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>">
                        <i class="icon-envelope"></i>
                </a>
            </div>
        </td>
    <?php } ?>
    </tr>
    <?php }
    } ?>
</table>