<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_CO , APP_PRESIDENTE]);

?>

<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
<div class="span5 allinea-sinistra">
        <h2>
            <i class="icon-thumbs-up muted"></i>
            Reperibilità
        </h2>
    </div>
    <div class="control-group" align="right">
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on"><i class="icon-search"></i></span>
                <input data-t="<?php echo $t; ?>" autofocus required id="cercaUtente" placeholder="Cerca Volontario..." class="span4" type="text">
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
$comitati= $me->comitatiApp ([ APP_CO, APP_PRESIDENTE ]);
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
            <td class="btn-group">     
            <a class="btn" href="?p=public.utente&id=<?php echo $_v->id; ?>" target="_new">
                    <i class="icon-eye-open"></i>
                        Visualizza
            </a>
            <a class="btn btn-success" href="?p=utente.mail.nuova&id=<?php echo $_v->id; ?>">
                    <i class="icon-envelope"></i>
            </a>
            </td>
    <?php } ?>
    </tr>
    <?php }
    } ?>
</table>