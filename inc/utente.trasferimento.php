<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
caricaSelettoreComitato();

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
        $x=0;
             foreach($me->riserve() as $riserva){
                 $riservafine = $riserva->fine;
             if($x==0 && $riserva && $me->inRiserva()){ ?>         
                    <div class="row-fluid">
                                        <h2><i class="icon-warning-sign muted"></i> In riserva</h2>
                                        <div class="alert alert-danger">
                                            <div class="row-fluid">
                                                <span class="span12">
                                                    <p>Sei attualmente in riserva</p>
                                                    <p>Rimarrai nel ruolo di riserva fino al <strong> <?php echo date('d-m-Y', $riserva->fine); ?></strong> alla fine di tale periodo potrai richiedere <strong>il trasferimento</strong>.</p>
                                                </span>
                                            </div>
                                        </div>           
                                    </div>
             <?php $x=1; }}
             if($x==0) {
    foreach ( $me->storico() as $app ) {
                         if($app->stato == MEMBRO_DIMESSO){
                             redirect('errore.comitato');
                         }
                         if ($app->attuale()) 
                                    {
                          $trasferimento = Trasferimento::by('appartenenza', $app->id);
                           if($app->stato == MEMBRO_PENDENTE){
                                    redirect('errore.comitato');
                                    $i=1; }elseif($trasferimento && $trasferimento->stato==TRASF_INCORSO && !$trasferimento->presaInCarico()){ ?>
                     <div class="row-fluid">
                                        <h2><i class="icon-warning-sign muted"></i> Richiesta trasferimento in elaborazione</h2>
                                        <div class="alert alert-block">
                                            <div class="row-fluid">
                                                <span class="span12">
                                                    <p>La tua richiesta di trasferimento presso il <strong><?php echo $app->comitato()->nomeCompleto(); ?></strong> è in fase di elaborazione.</p>
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
                                                    <p>La tua richiesta di trasferimento presso il <strong><?php echo $app->comitato()->nomeCompleto(); ?></strong> è stata presa in carico il <strong><?php echo date('d-m-Y', $trasferimento->protData); ?></strong> con numero di protocollo <strong><?php echo $trasferimento->protNumero; ?></strong>.</p>
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
            <input class="span8" type="text" name="comitato" id="comitato" readonly value="<?php echo $me->unComitato()->nomeCompleto(); ?>" />
            </div>
          </div>   
    <div class="control-group">
        <label class="control-label" for="inputComitato">Comitato Destinazione </label>
        <div class="controls">
            <a class="btn btn-inverse" data-selettore-comitato="true" data-input="inputComitato">
                Seleziona un comitato... <i class="icon-pencil"></i>
            </a>
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
    
 
<?php }} ?>
   </div>
</div>
