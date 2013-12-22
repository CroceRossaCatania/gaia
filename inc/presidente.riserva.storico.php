<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

controllaParametri(array('id'), 'presidente.riserva&err');

$v = $_GET['id'];
$v = Volontario::id($v);
proteggiDatiSensibili($v, [APP_SOCI, APP_PRESIDENTE]);
?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <h2>
                <i class="icon-pause muted"></i>
                Storico Riserve
            </h2>
            <p>Volontario: <strong><?= $v->nomeCompleto(); ?></strong></p>
            
        </div>
        
        <div class="row-fluid">
            
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Stato</th>
                    <th>Ruolo</th>
                    <th>Motivo riserva</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                    <th>Azioni</th>
                </thead>
                
                <?php foreach ( $v->riserve() as $app ) { ?>
                    <tr<?php if ($app->attuale()) { ?> class="success"<?php } ?>>
                        <td>
                            <?php if ($app->attuale()) { ?>
                                Attuale
                            <?php } else { ?>
                                Passato
                            <?php } ?>
                        </td>
                        
                        <td>
                            <strong><?php echo $conf['riserve'][$app->stato]; ?></strong>
                        </td>
                        
                        <td>
                            <?php echo $app->motivo; ?>
                        </td>
                        
                        <td>
                            <i class="icon-calendar muted"></i>
                            <?php echo $app->inizio()->inTesto(false); ?>
                        </td>
                        
                        <td>
                            <?php if ($app->fine) { ?>
                                <i class="icon-time muted"></i>
                                <?php echo $app->fine()->inTesto(false); ?>
                            <?php } else { ?>
                                <i class="icon-question-sign muted"></i>
                                Indeterminato
                            <?php } ?>
                        </td>
                        <td>
                            <a class="btn btn-small btn-info" href="?p=presidente.riservaRichiesta.stampa&id=<?php echo $app->id; ?>" title="Visualizza ricevuta" data-attendere="Attendere...">
                                <i class="icon-paperclip"></i> Richiesta
                            </a>
                        </td>
                        
                    </tr>
                <?php } ?>
            
            </table>
        </div>        
    </div>
</div>

