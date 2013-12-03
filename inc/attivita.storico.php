<?php

/*
 * ©2013 Croce Rossa Italiana
 */

richiediComitato();

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
            
        
        <div class="row-fluid">
            
            <div class="span7">
                <h2>
                    <i class="icon-list muted"></i>
                    I miei turni
                </h2>
            </div>
            
            <div class="span5">
                                    
                <a href="?p=attivita.storico.scarica" data-attendere="Generazione in corso..." class="btn btn-block btn-large">
                    <i class="icon-download-alt"></i> Scarica foglio di servizio
                </a>

                
                
            </div>
            
        </div>
                
        <div class="row-fluid">
       
        <table class="table table-bordered table-striped" id="partecipazioniAttivita">
            
            <thead>
                <th>Attività</th>
                <th>Stato</th>
                <th>Autorizzazioni</th>
            </thead>
            
            <?php
            $partecipazioni = $me->partecipazioni();
            foreach ( $partecipazioni as $part ) {
                $auts = $part->autorizzazioni();
                ?>
            

                <tr data-timestamp="<?php echo $part->turno()->fine()->toJSON(); ?>">
                    <td>
                        <p><strong><?php echo $part->attivita()->nome; ?></strong><br />
                        <?php echo $part->turno()->nome;  ?><br />
                        <?php echo $part->turno()->inizio()->inTesto(); ?></p>
                        
                        <a href="?p=attivita.scheda&id=<?php echo $part->attivita()->id.'#'.$part->turno()->id ; ?>">
                            <i class="icon-reply"></i> Vedi dettagli attività
                        </a>
                    </td>
                    
                    <td><big>
                        <?php if ( $part->stato == PART_OK ) { ?>
                            <span class="label label-success">
                                Ok!
                            </span><br />
                            Partecipazione confermata.
                        <?php } elseif ( $part->stato == PART_PENDING ) { ?>
                            <span class="label label-warning">
                                In attesa
                            </span><br />
                            La tua richiesta è in attesa di autorizzazione.
                        <?php } else { ?>
                            <span class="label label-important">
                                Negata
                            </span><br />
                            La tua richiesta di partecipazione è stata respinta.
                        <?php } ?>
                            
                        
                        <div class="progress">
                            <?php foreach ( $auts as $aut ) { ?>
                                <?php if ( $aut->stato == AUT_OK ) { ?>
                                    <div class="bar bar-success" style="width: <?php echo 1/count($auts)*100; ?>%;"></div>
                                <?php } elseif ( $aut->stato == AUT_PENDING ) { ?>
                                    <div class="bar bar-warning" style="width: <?php echo 1/count($auts)*100; ?>%;"></div>
                                <?php } else { ?>
                                    <div class="bar bar-danger" style="width: <?php echo 1/count($auts)*100; ?>%;"></div>
                                <?php } ?>
                             <?php } ?>
                          </div>

                    </big></td>
                    <td>

                            
                        <?php foreach ( $auts as $aut ) { ?>

                            <?php if ( $aut->stato == AUT_OK ) { ?>
                                <i class="icon-ok"></i>
                                <?php echo $aut->volontario()->nomeCompleto(); ?>
                                
                            <?php } elseif ( $aut->stato == AUT_PENDING ) { ?>
                                <i class="icon-time"></i>
                                <?php echo $aut->volontario()->nomeCompleto(); ?>
                                
                            <?php } else { ?>
                                <i class="icon-remove"></i>
                                <?php echo $aut->volontario()->nomeCompleto(); ?>
                                (<span class="muted"><?php echo $aut->tFirma()->inTesto(); ?></span>)
                            <?php } ?>
                                
                                <br />
                        <?php } ?>

                    </td>
                </tr>
                <?php } ?>
                <tr class="nascosto" id="rigaMostraTuttiTurni">
                        <td colspan="4">
                            <a id="mostraTuttiTurni" class="btn btn-block">
                                <i class="icon-info-sign"></i>
                                Ci sono <span id="numTurniNascosti"></span> turni passati nascoste.
                                <strong>Clicca per mostrare i turni passati nascoste.</strong>
                            </a>
                        </td>
                    </tr>     
        </table>
            
                                 
        <?php if (!$partecipazioni) { ?>

            <div class="alert alert-block alert-info">
                <h4><i class="icon-info-sign"></i> Qui vedrai lo storico dei tuoi turni</h4>
                <p>In questa pagina vedrai lo storico dei tuoi turni e lo stato delle autorizzazioni per parteciparvi.</p>
                <p><a class="btn btn-large btn-block" href="?p=attivita">
                        <i class="icon-calendar"></i> Vai al Calendario delle Attività
                    </a></p>
            </div>
        
        <?php } ?>
       
        </div>
        
    </div>
      
    
</div>

