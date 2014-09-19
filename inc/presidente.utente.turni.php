<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

controllaParametri(array('id'));

$v = $_GET['id'];
$v = Volontario::id($v);
?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
    <div class="span5 allinea-sinistra">
        <h2>
            <i class="icon-time muted"></i>
            Storico turni
        </h2>
        <p>Volontario: <strong><?= $v->nomeCompleto(); ?></strong></p>
    </div>
            
        <div class="span3">
        </div>
    
    <div class="span4 allinea-destra">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus required id="cercaUtente" placeholder="Cerca Turno..." type="text">
        </div>
    </div>    
</div>
    
<hr />
    
<div class="row-fluid">
       
    <table class="table table-bordered table-striped">
        
        <thead>
            <th>Attività</th>
            <th>Stato</th>
            <th>Autorizzazioni</th>
        </thead>
        
        <?php
        $partecipazioni = $v->partecipazioni();
        foreach ( $partecipazioni as $part ) {
            $auts = $part->autorizzazioni();
            ?>
        

            <tr>
                <td>
                    <p><strong><?php echo $part->attivita()->nome; ?></strong><br />
                    <?php echo $part->turno()->nome;  ?> dal:
                    <strong><?php echo date('d/m/Y H:i', $part->turno()->inizio); ?></strong> al:
                    <strong><?php echo date('d/m/Y H:i', $part->turno()->fine); ?></strong>
                    </p>
                    <a href="?p=attivita.scheda&id=<?php echo $part->attivita()->id; ?>" target="_new">
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
    </table>                     
    <?php if (!$partecipazioni) { ?>
        <div class="alert alert-block alert-danger allinea-centro">
            <h4><i class="icon-info-sign"></i> Il volontario non ha effettuato turni</h4>
        </div>
    <?php } ?>
   
    </div>