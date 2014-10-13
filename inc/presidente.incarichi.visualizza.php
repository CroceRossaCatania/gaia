<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

controllaParametri(array('id'), 'presidente.riserva&err');

$u = $_GET['id'];
$u = Volontario::id($u);
proteggiDatiSensibili($u, [APP_SOCI, APP_PRESIDENTE]);
?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <h2>
                <i class="icon-briefcase muted"></i>
                Storico Incarichi
            </h2>
            <p>Volontario: <strong><?= $u->nomeCompleto(); ?></strong></p>
            
        </div>
        
        <div class="row-fluid">
            
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Stato</th>
                    <th>Ruolo</th>
                    <th>Comitato</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                </thead>
                <?php foreach ( $u->storicoDelegazioni() as $app ) { ?>
                <tr<?php if ($app->fine >= time() || $app->fine == 0 ) { ?> class="success"<?php } ?>>
                    <td>
                        <?php if ($app->fine >= time() || $app->fine == 0 ) { ?>
                            Attuale
                            <?php } else { ?>
                            Passato
                            <?php } ?>
                    </td>
                    <td>
                        <?php switch ( $app->applicazione ) { 
                            case APP_PRESIDENTE:
                            ?>
                                <strong>Presidente</strong>
                                <?php
                                break;
                            case APP_ATTIVITA:
                            ?>
                                <strong>Referente</strong>
                                <?php echo $conf['app_attivita'][$app->dominio]; ?>
                                <?php
                                break;
                            case APP_OBIETTIVO:
                            ?>
                                <strong>Delegato</strong>
                                <?php echo $conf['obiettivi'][$app->dominio]; ?>
                                <?php
                                break;
                            default:
                            ?>
                                <strong><?php echo $conf['applicazioni'][$app->applicazione]; ?></strong>
                                <?php
                                break;
                        } ?>
                    </td>
                    <td>
                        <?php echo $app->comitato()->nomeCompleto(); ?>
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
                </tr>
            <?php } ?>
            </table>
        </div>        
    </div>
</div>

