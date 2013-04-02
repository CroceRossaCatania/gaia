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
        <?php if ( isset($_GET['e']) ) { ?>
        <div class="alert alert-error">
            <i class="icon-warning-sign"></i>
            <strong>Errore</strong> &mdash; Appartieni già a questo Comitato.
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
                                        <h2><i class="icon-warning-sign muted"></i> Impossibile richiedere trasferimento</h2>
                                        <div class="alert alert-error">
                                            <div class="row-fluid">
                                                <span class="span12">
                                                    <p>Ci dispiace ma non puoi chiedere il trasferimento finchè la tua appartenenza al  <strong><?php echo $app->comitato()->nome; ?></strong> è pendente.</p>
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
            <h2><i class="icon-chevron-right muted"></i> Richiesta trasferimento</h2>
            <div class="alert alert-block alert-info ">
                <div class="row-fluid">
                    <span class="span7">
                        <h4>Vuoi trasferirti ad un altro Comitato ?</h4>
                        <p>Con questo modulo puoi richiedere il trasferimento ad un altro Comitato</p>
                        <p>Seleziona il Comitato a cui vuoi trasferirti e clicca su invia richiesta.</p>
                    </span>
                </div>
            </div>           
        </div>
        
<div class="row-fluid">
    <form class="form-horizontal" action="?p=utente.trasferimento.ok&id=<?php echo $me->id; ?>" method="POST">
     <div class="control-group">
        <label class="control-label" for="comitato">Comitato Attuale </label>
        <div class="controls">
            <input class="span8" type="text" name="comitato" id="comitato" readonly value="<?php echo $me->unComitato()->nome; ?>" />
            </div>
          </div>   
    <div class="control-group">
        <label class="control-label" for="inputComitato">Comitato Destinazione </label>
        <div class="controls">
            <select required name="inputComitato" autofocus class="span8">
                    <?php foreach ( Comitato::elenco('nome ASC') as $c ) { ?>
                        <option value="<?php echo $c->id; ?>"><?php echo $c->nome; ?></option>
                    <?php } ?>
            </select>
            </div>
          </div>
   <div class="control-group">
        <label class="control-label" for="inputMotivo">Motivazione </label>
        <div class="controls">
            <input class="span8" type="text" name="inputMotivo" id="motivo" placeholder="es.: Motivi Personali" required>
            </div>
          </div>
    <div class="control-group">
            <div class="controls">
              <button type="submit" class="btn btn-large btn-success">
                  <i class="icon-ok"></i>
                  Invia richiesta
              </button>
            </div>
          </div>
        </div>
    
    </div>
</div>
<?php } ?>



