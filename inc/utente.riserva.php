<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
richiediComitato();

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
    if ( isset($_GET['ann']) ) { ?>
      <div class="alert alert-success">
        <i class="icon-save"></i> <strong>Richiesta annullata</strong>.
        La richiesta di riserva è stata annullata con successo.
      </div>
    <?php }
    if ( isset($_GET['gia']) ) { ?>
      <div class="alert alert-danger">
        <i class="icon-save"></i> <strong>Richiesta già presente</strong>.
        E' già presente una richiesta di riserva.
      </div>
    <?php }
    if ( isset($_GET['err']) ) { ?>
      <div class="alert alert-danger">
        <i class="icon-warning-sign"></i> <strong>Date non corrette</strong>.
        La date che hai inserito sono incorrette.
      </div>
    <?php }  
    $i=0;
    foreach ( $me->storico() as $app ) { 
     if ($app->attuale()) 
     {
       if($app->stato == MEMBRO_PENDENTE){ 
        redirect('errore.comitato');  
        $i=1; }}}
        foreach($me->riserve() as $riserva){
         $riservafine = $riserva->fine;
         if($riserva && $riserva->stato==RISERVA_INCORSO && !$riserva->presaInCarico()){ ?>
         <div class="row-fluid">
          <h2><i class="icon-warning-sign muted"></i> Richiesta riserva in elaborazione</h2>
          <div class="alert alert-block">
            <div class="row-fluid">
              <span class="span12">
                <p>La tua richiesta di transito nel ruolo di riserva è in fase di elaborazione.</p>
                <p>La tua richiesta è in attesa di essere protocollata dalla segreteria del tuo Comitato,
                 potrai chiederne l'annullamento fino a quel momento.</p>
               </span>
             </div>
           </div>           
         </div>
         <div class="row-fluid">
          <form class="form-horizontal" action="?p=utente.riserva.sospendi.ok" method="POST">
            <input type="hidden" name="elimina" value="true" >
            <button type="submit" class="btn btn-block btn-danger">
              <i class="icon-remove"></i> Annulla la richiesta di transito nel ruolo di riserva
            </button>
          </form>
          <div>
            <?php $i=2;  } 
            if($riserva && $riserva->presaInCarico() && $riserva->stato==RISERVA_INCORSO){ ?>         
            <div class="row-fluid">
              <h2><i class="icon-warning-sign muted"></i> Richiesta riserva presa in carico</h2>
              <div class="alert alert-block">
                <div class="row-fluid">
                  <span class="span12">
                    <p>La tua richiesta di riserva è stata presa in carico il <strong><?php echo date('d-m-Y', $riserva->protData); ?></strong> con numero di protocollo <strong><?php echo $riserva->protNumero; ?></strong>.</p>
                    <p>La tua richiesta è in attesa di conferma da parte del tuo Presidente di Comitato.</p>
                    <p>Da questo momento non puoi più annullare la richiesta. Se hai cambiato idea contatta il tuo Presidente.</p>
                  </span>
                </div>
              </div>           
            </div>
            <?php $i=3; } 
            if($riserva && $riserva->stato==RISERVA_OK && $riservafine >= time()){ ?>         
            <div class="row-fluid">
              <h2><i class="icon-ok-sign muted"></i> Richiesta di riserva approvata</h2>
              <div class="alert alert-success">
                <div class="row-fluid">
                  <span class="span12">
                    <p>La tua richiesta di riserva è stata approvata.</p>
                    <p>Rimarrai nel ruolo di riserva dal <strong> <?php echo date('d-m-Y', $riserva->inizio); ?></strong> fino al <strong> <?php echo date('d-m-Y', $riserva->fine); ?></strong>.</p>
                  </span>
                </div>
              </div>           
            </div>
            <?php $i=4; }}
            if($i==0){ ?>
            <div class="row-fluid">
              <h2><i class="icon-pause muted"></i> Richiesta Riserva</h2>
              <div class="alert alert-block alert-info ">
                <div class="row-fluid">
                  <span class="span7">
                    <h4>Vuoi transitare nel ruolo di riserva ?</h4>
                    <p>Con questo modulo puoi richiedere il transito nel ruolo di riserva</p>
                    <p>Seleziona il periodo in cui vuoi stare nel ruolo di riserva.</p>
                  </span>
                </div>
              </div>           
            </div>
            
            <div class="row-fluid">
              <form class="form-horizontal" action="?p=utente.riserva.ok&id=<?php echo $me->id; ?>" method="POST">
               <div class="control-group">
                <label class="control-label" for="datainizio">Data inizio </label>
                <div class="controls">
                  <input class="input-medium" type="text" name="datainizio" id="datainizio" required>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="datafine">Data fine </label>
                <div class="controls">
                  <input class="input-medium" type="text" name="datafine" id="datafine" required>
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
