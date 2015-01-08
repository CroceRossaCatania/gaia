<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
richiediComitato();
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
        <?php } 
        if ( isset($_GET['e']) ) { ?>
          <div class="alert alert-error">
              <i class="icon-warning-sign"></i>
              <strong>Errore</strong> &mdash; Appartieni già a questo Comitato oppure hai già richiesto l'estensione su questo Comitato.
          </div>
        <?php } 
        if ( isset($_GET['ann']) ) { ?>
          <div class="alert alert-success">
              <i class="icon-save"></i> <strong>Richiesta annullata</strong>.
              La richiesta è stata annullata con successo.
          </div>
        <?php } 
        if ( isset($_GET['motivo']) ) { ?>
          <div class="alert alert-error">
              <i class="icon-warning-sign"></i>
              <strong>Errore</strong> &mdash; Non è stato specificato il motivo dell'estensione o il Comitato.
          </div>
        <?php }

    foreach ( $me->storico() as $app ) {
                         if($app->stato == MEMBRO_DIMESSO){
                             redirect('errore.comitato');
                         }
                         if ($app->attuale()) 
                                    {
                          $estensione = Estensione::by('appartenenza', $app->id);
                           if($estensione && $estensione->stato==EST_INCORSO && !$estensione->presaInCarico()){ ?>
                     <div class="row-fluid">
                                        <h2><i class="icon-warning-sign muted"></i> Richiesta estensione in elaborazione</h2>
                                        <div class="alert alert-block">
                                            <div class="row-fluid">
                                                <span class="span12">
                                                    <p>La tua richiesta di estensione presso il <strong><?php echo $app->comitato()->nomeCompleto(); ?></strong> è in fase di elaborazione.</p>
                                                    <p>La tua richiesta è in attesa di essere protocollata dalla segreteria del tuo Comitato, 
                                                    potrai chiederne l'annullamento fino a quel momento.</p>
                                                </span>
                                            </div>
                                            <form class="form-horizontal" action="?p=utente.estensione.sospendi.ok" method="POST" style="margin-bottom: 0px;">
                                        <input type="hidden" name="elimina" value="<?php echo($estensione->id); ?>" >
                                        <button type="submit" class="btn btn-block btn-danger">
                                          <i class="icon-remove"></i> Annulla la richiesta di estensione
                                        </button>
                                      </form>
                                    </div>
                                    </div>
              <?php  }elseif($estensione && $estensione->presaInCarico() && $estensione->stato==EST_INCORSO){ ?>         
                    <div class="row-fluid">
                                        <h2><i class="icon-warning-sign muted"></i> Richiesta estensione presa in carico</h2>
                                        <div class="alert alert-block">
                                            <div class="row-fluid">
                                                <span class="span12">
                                                    <p>La tua richiesta di estensione presso il <strong><?php echo $app->comitato()->nomeCompleto(); ?></strong> è stata presa in carico il <strong><?php echo date('d-m-Y', $estensione->protData); ?></strong> con numero di protocollo <strong><?php echo $estensione->protNumero; ?></strong>.</p>
                                                    <p>La tua richiesta è in attesa di conferma da parte del tuo Presidente di Comitato.</p>
                                                    <p>Trascorsi 30 giorni senza alcuna risposta del Presidente Gaia effettuerà l'estensione automaticamente come previsto da regolamento.</p>
                                                    <p>Da questo momento non puoi più annullare la richiesta. Se hai cambiato idea contatta il tuo Presidente.</p>
                                                </span>
                                            </div>
                                        </div>           
                                    </div>
             <?php } } } 
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
                                                    <p>Rimarrai nel ruolo di riserva fino al <strong> <?php echo date('d-m-Y', $riserva->fine); ?></strong> alla fine di tale periodo potrai richiedere <strong>l'estensione</strong>.</p>
                                                </span>
                                            </div>
                                        </div>           
                                    </div>
             <?php $x=1; }}
             if($x==0) { ?>
        <div class="row-fluid">
            <h2><i class="icon-chevron-right muted"></i> Richiesta estensione</h2>
            <div class="alert alert-block alert-info ">
                <div class="row-fluid">
                    <span class="span7">
                        <h4>Vuoi richiedere l'estesione su di un altro Comitato ?</h4>
                        <p>Con questo modulo puoi richiedere l'estensione ad un altro Comitato</p>
                        <p>Seleziona il Comitato su cui vuoi richiedere l'estensione e 
                        clicca su invia richiesta.</p>
                    </span>
                </div>
            </div>           
        </div>
        
<div class="row-fluid">
    <form class="form-horizontal" action="?p=utente.estensione.ok" method="POST">
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
             <?php } ?>
 

   </div>
</div>
