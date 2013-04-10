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
            <i class="icon-save"></i> <strong>Iscritto al gruppo</strong>.
            Sei stato iscritto con successo al gruppo di lavoro.
        </div>
        <?php } ?>
        <?php if ( isset($_GET['e']) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i> <strong>Già iscritto al gruppo</strong>.
            Sei già iscritto a questo gruppo di lavoro.
        </div>
        <?php } ?>
        <?php if ( isset($_GET['last']) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i> <strong>Devi appartenere almeno ad un gruppo</strong>.
            Non puoi abbandonare il gruppo, perchè devi essere iscritto almeno ad un gruppo.
        </div>
        <?php } ?>
        <?php if ( isset($_GET['del']) ) { ?>
        <div class="alert alert-success">
            <i class="icon-ok"></i> <strong>Gruppo abbandonato</strong>.
           Hai abbandonato il gruppo di lavoro con successo.
        </div>
        <?php } ?>
        <?php 
    $i=0;
    foreach ( $me->storico() as $app ) { 
                         if ($app->attuale()) 
                                    {
                          $trasferimento = Trasferimento::by('appartenenza', $app->id);
                           if($app->stato == MEMBRO_PENDENTE){ 
                               redirect('errore.comitato');
                               $i=1; }elseif($trasferimento && $trasferimento->stato==TRASF_INCORSO){ ?>
                     <div class="row-fluid">
                                        <h2><i class="icon-warning-sign muted"></i> Impossibile richiedere iscrizione a gruppo di lavoro</h2>
                                        <div class="alert alert-error">
                                            <div class="row-fluid">
                                                <span class="span12">
                                                    <p>Ci dispiace ma non puoi chiedere l'iscrizione ad un gruppo di lavoro finchè il tuo trasferimento è pendente.</p>
                                                </span>
                                            </div>
                                        </div>           
                                    </div>  
             <?php $i=2; } } }
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
    <form class="form-horizontal" action="?p=utente.gruppo.nuovo.ok&id=<?php echo $me->id; ?>" method="POST">
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
                    <th>Nome</th>
                    <th>Comitato</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                    <th>Azione</th>
                </thead>
                
                <?php foreach ( $me->mieiGruppi() as $app ) { ?>
                    <tr<?php if ($app->attuale()) { ?> class="success"<?php } ?>>
                        <td>
                            <?php if ($app->attuale()) { ?>
                                Attuale
                            <?php } else { ?>
                                Passato
                            <?php } ?>
                        </td>
                        
                        <td>
                            <strong><?php echo $app->nome; ?></strong>
                        </td>
                        
                        <td>
                            <strong><?php echo $app->appartenenza()->comitato()->nome; ?></strong>
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
                            <?php if ($app->attuale()) { ?>
                            <a class="btn btn-danger" onClick="return confirm('Vuoi veramente abbandonare questo gruppo di lavoro ?');" href="?p=utente.gruppo.dimetti&id=<?php echo $app->id; ?>">
                                <i class="icon-ban-circle"></i>
                                Abbandona
                            </a>
                            <?php } ?>
                        </td>
                        
                    </tr>
                <?php } ?>
            
            </table>
        </div>
    
        </div>

<?php } ?>  
    </div>
   </div>