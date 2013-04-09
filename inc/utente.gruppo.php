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
        <?php if ( isset($_GET['ok']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-save"></i> <strong>Richiesta inviata</strong>.
            La richiesta è stata inviata con successo.
        </div>
        <?php } ?>
        <?php 
    $i=0;
    foreach ( $me->storico() as $app ) { 
                         if ($app->attuale()) 
                                    {
                          $trasferimento = Trasferimento::by('appartenenza', $app->id);
                           if($app->stato == MEMBRO_PENDENTE){ ?> 
                                    <div class="row-fluid">
                                        <h2><i class="icon-warning-sign muted"></i> Impossibile richiedere iscrizione a gruppo di lavoro</h2>
                                        <div class="alert alert-error">
                                            <div class="row-fluid">
                                                <span class="span12">
                                                    <p>Ci dispiace ma non puoi chiedere l'iscrizione ad un gruppo di lavoro finchè la tua appartenenza al  <strong><?php echo $app->comitato()->nome; ?></strong> è pendente.</p>
                                                    <p>Contatta il tuo Presidente per chiedere la conferma della tua appartenenza.</p>
                                                </span>
                                            </div>
                                        </div>           
                                    </div>    
                 <?php $i=1; }elseif($trasferimento && $trasferimento->stato==TRASF_INCORSO && !$trasferimento->presaInCarico()){ ?>
                     <div class="row-fluid">
                                        <h2><i class="icon-warning-sign muted"></i> Richiesta trasferimento in elaborazione</h2>
                                        <div class="alert alert-block">
                                            <div class="row-fluid">
                                                <span class="span12">
                                                    <p>La tua richiesta di trasferimento presso il <strong><?php echo $app->comitato()->nome; ?></strong> è in fase di elaborazione.</p>
                                                    <p>La tua richiesta è in attesa di essere protocollata dalla segreteria del tuo Comitato.</p>
                                                </span>
                                            </div>
                                        </div>           
                                    </div>
              <?php $i=2;  }elseif($trasferimento && $trasferimento->presaInCarico() && $trasferimento->stato==TRASF_INCORSO){ ?>         
                    <div class="row-fluid">
                                        <h2><i class="icon-warning-sign muted"></i> Richiesta trasferimento presa in carico</h2>
                                        <div class="alert alert-block">
                                            <div class="row-fluid">
                                                <span class="span12">
                                                    <p>La tua richiesta di trasferimento presso il <strong><?php echo $app->comitato()->nome; ?></strong> è stata presa in carico il <strong><?php echo date('d-m-Y', $trasferimento->protData); ?></strong> con numero di protocollo <strong><?php echo $trasferimento->protNumero; ?></strong>.</p>
                                                    <p>La tua richiesta è in attesa di conferma da parte del tuo Presidente di Comitato.</p>
                                                    <p>Trascorsi 30 giorni senza alcuna risposta del Presidente Gaia effettuerà il trasferimento automaticamente come previsto da regolamento.</p>
                                                </span>
                                            </div>
                                        </div>           
                                    </div>
             <?php $i=3; } } }
if($i==0){ ?>
        <div class="row-fluid">
            <h2><i class="icon-flag muted"></i> Gruppi di lavoro</h2>
            <div class="alert alert-block alert-info ">
                <div class="row-fluid">
                    <span class="span9">
                        <h4>Vuoi iscriverti ad un gruppo di lavoro ?</h4>
                        <p>Con questo modulo puoi richiedere l'iscrizione ad un gruppo di lavoro presente nel tuo Comitato</p>
                        <p>Seleziona il Gruppo a cui vuoi iscriverti e clicca su iscriviti</p>
                    </span>
                </div>
            </div>           
        </div>
        
<div class="row-fluid">
    <form class="form-horizontal" action="?p=utente.gruppo.ok&id=<?php echo $me->id; ?>" method="POST">
   <div class="control-group">
        <label class="control-label" for="inputGruppo">Gruppi di lavoro </label>
        <div class="controls">
            <input class="span8" type="text" name="inputGruppo" id="inputGruppo" placeholder="es.: Gruppo w alfio fresta" required>
            </div>
          </div>
        <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-success">
                  <i class="icon-ok"></i>
                  Iscriviti
              </button>
            </div>
          </div>
        <div class="row-fluid">
            <h2>
                <i class="icon-flag muted"></i>
                Gruppi
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
                    <th>Azione</th>
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
                        
                        <td>
                            <a class="btn btn-danger" onClick="return confirm('Vuoi veramente dimetterti da questo gruppo di lavoro ?');" href="?p=utente.gruppo.dimetti&id=<?php echo $me->id; ?>">
                                <i class="icon-ban-circle"></i>
                                Abbandona
                            </a>
                        </td>
                        
                    </tr>
                <?php } ?>
            
            </table>
        </div>
    
        </div>
    
    </div>
</div>
<?php } ?>



