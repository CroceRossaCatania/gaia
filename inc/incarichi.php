<?php

/*
 * ©2013 Croce Rossa Italiana
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
                Storico incarichi di Croce Rossa
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
                
                <?php foreach ( $me->delegazioni() as $app ) { ?>
                    <tr<?php if ($app->fine >= time() || $app->fine == 0 ) { ?> class="success"<?php } ?>>
                        <td>
                            <?php if ($app->fine >= time() || $app->fine == 0 ) { ?>
                                Attuale
                            <?php } else { ?>
                                Passato
                            <?php } ?>
                        </td>
                        
                        <td>
                            <strong>Referente <?php echo $conf['app_attivita'][$app->dominio]; ?></strong>
                        </td>
                        
                        <td>
                            <?php echo $app->comitato()->nome; ?>
                        </td>
                        
                        <td>
                            <i class="icon-calendar muted"></i>
                            <?php echo date('d-m-Y', $app->inizio); ?>
                        </td>
                        
                        <td>
                            <?php if ($app->fine) { ?>
                                <i class="icon-time muted"></i>
                                <?php echo date('d-m-Y', $app->fine); ?>
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

