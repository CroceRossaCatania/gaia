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

//Inizializzo array dei gruppi
$gruppi = [];

//Privacy pagina?
//paginaApp([APP_PRESIDENTE,APP_SOCI,]);

//Seleziono i comitati di cui sono presidente
$comitati = $me->comitatiApp([APP_PRESIDENTE, APP_SOCI]);

foreach ($comitati as $comitato) {
    $gruppi = array_merge($gruppi, $comitato->gruppi());
}


if ($me->attivitaReferenziate()){
    $gruppi = Gruppo::filtra([
        ['referente',$me]
    ]);
}

$gruppi = array_unique($gruppi);

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
                    
                    <a class="btn btn-small btn-danger pull-right" onclick="return confirm('Sei davvero sicuro di voler eliminare il gruppo?');" href="?p=gruppi.elimina&id=<?php echo $gruppo->id; ?>" title="Elimina gruppo">
                        <i class="icon-trash"></i> Elimina
                    </a>
                </td>
            </tr>
<?php
    foreach($gruppo->membri() as $volontario){
?>
                <tr>
                    <td><?php echo $volontario->cognome; ?></td>
                    <td><?php echo $volontario->nome; ?></td>
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