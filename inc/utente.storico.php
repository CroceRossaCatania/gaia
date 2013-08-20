<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPrivata();

?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            <h2>
                <i class="icon-time muted"></i>
                Appartenenze
            </h2>
            
        </div>
        
        <div class="row-fluid">
            
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Stato</th>
                    <th>Ruolo</th>
                    <th>Comitato</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                    <th>Azioni</th>
                </thead>
                
                <?php foreach ( $me->storico() as $app ) { ?>
                    <tr<?php if ($app->attuale()) { ?> class="success"<?php } ?>>
                        <td>
                            <?php if ($app->attuale()) { ?>
                                Attuale
                            <?php } else { ?>
                                Passato
                            <?php } ?>
                        </td>
                        
                        <td>
                            <strong><?php echo $conf['membro'][$app->stato]; ?></strong>
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
                        <td>
                            <?php if ( $app->stato == MEMBRO_ESTESO ){ ?>
                                <a class="btn btn- small btn-danger" href="?p=utente.estensione.termina&id=<?= $app->id; ?>" title="Termina Estensione">
                                    <i class="icon-stop"></i> Termina Estensione
                                </a> 
                            <?php } ?>
                        </td>
                        
                    </tr>
                <?php } ?>
            
            </table>
        </div>
    
<?php if ( $me->riserve() ) { ?>
<div class="row-fluid">
            <h2>
                <i class="icon-pause muted"></i>
                Riserve
            </h2>
            
        </div>
        
        <div class="row-fluid">
            
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Stato</th>
                    <th>Ruolo</th>
                    <th>Motivo riserva</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                </thead>
                
                <?php foreach ( $me->riserve() as $app ) { ?>
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
                        
                    </tr>
                <?php } ?>
            
            </table>
        </div> 
<?php } ?>        

<?php if ( $me->storicoDelegazioni() ) { ?>
        <div class="row-fluid">
            <h2>
                <i class="icon-briefcase muted"></i>
                Incarichi
            </h2>
            
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
                
                <?php foreach ( $me->storicoDelegazioni() as $app ) { ?>
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
                                    
                            }
                            ?>
                            
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
   <?php } ?>        
    </div>
</div>

