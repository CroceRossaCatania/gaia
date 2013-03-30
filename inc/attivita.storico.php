<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();


?>
<div class="row-fluid">
    
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>

    <div class="span9">
        
        <?php if (isset($_GET['okpending']) ) { ?>
            <div class="alert alert-block alert-warning">
                <h4><i class="icon-time"></i> Partecipazione in attesa di conferma</h4>
                <p>Hai chiesto l'autorizzazione a partecipare al turno selezionato.</p>
                <p>Puoi controllare lo stato dell'autorizzazione da questa pagina.</p>
                <p><strong>Ti informeremo per email non appena ti verrà concessa!</strong></p>
            </div>
        <?php } ?>
            
        <h2><i class="icon-list"></i> Le mie Attività in Croce Rossa</h2>
       
        <table class="table table-bordered table-striped">
            
            <thead>
                <th>Attività</th>
                <th>Stato</th>
            </thead>
            
            <?php
            $partecipazioni = $me->partecipazioni();
            foreach ( $partecipazioni as $part ) { ?>
            
                <?php
                if ( $part->stato == PART_PENDING ) { 
                    $classe = 'warning';
                } elseif ( $part->stato == PART_NO ) {
                    $classe = 'error';
                } else {
                    $classe = '';
                } 
                ?>
                <tr class="<?php echo $classe; ?>">
                    <td>
                        <strong><?php echo $part->attivita()->nome; ?></strong><br />
                        <?php echo $part->turno()->nome;  ?><br />
                        <a href="?p=attivita.scheda&id=<?php echo $part->attivita()->id; ?>" class="btn btn-block">
                            <i class="icon-reply"></i> Vai all'Attività
                        </a>
                    </td>
                    <td>
                        <table class="table table-condensed">
                            
                            <thead>
                                <th>Stato</th>
                                <th>Firmatario</th>
                                <th>Aggiornamento</th>
                            </thead>
                            
                            <?php foreach ( $part->autorizzazioni() as $aut ) { ?>
                            <tr>
                                <td><strong><?php echo $conf['autorizzazione'][$aut->stato]; ?></td>
                                <td><?php echo $aut->volontario()->nomeCompleto(); ?></td>
                                <td>
                                    <?php if ( $aut->tFirma ) { ?>
                                     <i class="icon-time"></i> <?php echo $aut->tFirma()->format('d-m-Y H:i'); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                            
                            <tr>
                                <td>STATO COMPLESSIVO</td>
                                <td colspan="2"><strong>Partecipazione <?php echo $conf['partecipazione'][$part->stato]; ?></strong></td>
                            </tr>
                            
                        </table>
                    </td>
                </tr>
            <?php } ?>
                        
            
        </table>
                                 
        <?php if (!$partecipazioni) { ?>

            <div class="alert alert-block alert-info">
                <h4><i class="icon-info-sign"></i> Qui vedrai lo storico delle tue attività</h4>
                <p>In questa pagina vedrai lo storico delle tue attività e lo stato delle autorizzazioni per parteciparvi.</p>
                <p><a class="btn btn-large btn-block" href="?p=attivita">
                        <i class="icon-calendar"></i> Vai alla pagina delle Attività
                    </a></p>
            </div>
        
        <?php } ?>
       
    </div>
      
    
</div>

