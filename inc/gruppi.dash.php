<?php

/*
 * ©2013 Croce Rossa Italiana
 */

?>
<br/>
<div class="row-fluid">
    <div class="span6 allinea-sinistra">
        <h2>
            <i class="icon-group muted"></i>
            Elenco gruppi
        </h2>
    </div>
    <div class="span6 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Volontari..." type="text">
        </div>
    </div>    
</div>

<?php

/*
 * il presidente vede tutti i gruppi del suo comitato, il referente il gruppo di cui è referente
 */

$gruppi = $me->gruppiDiCompetenza();

if ( isset($_GET['cancellato'] ) ) {
    ?>
    <div class="alert alert-success">
        <i class="icon-trash"></i> Gruppo cancellato con successo
    </div>
    <?php
}
?>
 <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
            <thead>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Cellulare</th>
                <th>Azioni</th>
            </thead>
<?php
foreach ($gruppi as $gruppo){
    ?>
        <tr class="success">
                    <td colspan="7">
                        <strong>
                            <?php echo $gruppo->nome; ?>
                        </strong>
                         <a class="btn btn-success btn-small pull-right" href="?p=utente.mail.nuova&id=<?php echo $gruppo->id; ?>&gruppo">
                           <i class="icon-envelope"></i> Invia mail
                        </a>
                     <?php if ( $me->presidenziante() || $me->admin() ){ ?>
                        <a class="btn btn-small btn-danger pull-right" onclick="return confirm('Sei davvero sicuro di voler eliminare il gruppo?');" href="?p=gruppi.elimina&id=<?php echo $gruppo->id; ?>" title="Elimina gruppo">
                            <i class="icon-trash"></i> Elimina
                        </a>
                     <?php } ?>
                    </td>
                </tr>
    <?php
        foreach($gruppo->membri() as $volontario){
    ?>
                    <tr>
                        <td><?= $volontario->cognome; ?>    </td>
                        <td><?= $volontario->nome; ?>       </td>
                        <td><?= $volontario->cellulare(); ?></td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-small" href="?p=public.utente&id=<?php echo $volontario->id; ?>" target="_new"  title="Dettagli">
                                    <i class="icon-eye-open"></i> Dettagli
                                </a>

                                <a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $volontario->id; ?>" target="_new" title="Invia Mail">
                                    <i class="icon-envelope"></i>
                                </a>
                            </div>
                       </td>
                    </tr>
    <?php
        }
}

?>
 </table>