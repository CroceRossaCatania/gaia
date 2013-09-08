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
        
        <h2>
            <i class="icon-certificate muted"></i>
            Richieste di partecipazione
        </h2>
        <hr />

        <?php
        $richieste = $me->autorizzazioniPendenti(); 
        if (!$richieste) { ?>
            <h4 class="text-success">Nessun'altra richiesta, per ora.</h4>
            <p>Verrai avvertito per email non appena ti verrà richiesto di
                autorizzare una partecipazione ad attività.</p>
        <?php } ?>
            
            
            <table class="table table-bordered table-striped">
                
                
                <thead>
                    <th>Volontario</th>
                    <th>Attività</th>
                    <th>Richiesta</th>
                    <th>Azione</th>
                </thead>
            
                <?php foreach ( $richieste as $richiesta ) {
                    $v = $richiesta->partecipazione()->volontario();
                    $t = $richiesta->partecipazione()->turno();
                    $a = $t->attivita();
                    ?>
                    <tr>
                        <td>
                            <strong><?php echo $v->nomeCompleto(); ?></strong><br />
                            (<?php echo $v->unComitato()->nomeCompleto(); ?>)
                        </td>
                        <td>
                            <a target="_new" href="?p=attivita.scheda&id=<?php echo $a->id; ?>">
                                <strong><?php echo $a->nome; ?></strong><br />
                                <?php echo $t->nome; ?><br />
                            </a>
                            <?php echo $t->inizio()->inTesto(); ?>
                        </td>
                        <td>
                            Richiesta effettuata:<br />
                            <i class="icon-time"></i> 
                            <?php echo $richiesta->timestamp()->inTesto(); ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-vertical">
                            <a data-autorizzazione="<?php echo $richiesta->id; ?>" data-accetta="1" class="btn btn-success">
                                <i class="icon-ok"></i> Concedi
                            </a>
                            <a data-autorizzazione="<?php echo $richiesta->id; ?>" data-accetta="0" class="btn btn-danger">
                                <i class="icon-remove"></i> Nega
                            </a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                }
                ?>
                        
                
                
            </table>
        
        



    </div>
</div>