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
                <i class="icon-save"></i> <strong>Reperibilità inviata</strong>.
                Grazie della disponibilità! Verrai contattato dalla Centrale Operativa in caso di necessità.
            </div>
        <?php } ?>
        <?php if ( isset($_GET['comitato']) ) { ?>
            <div class="alert alert-danger">
                <i class="icon-ban-circle"></i> <strong>Comitato mancante</strong>.
                Non risulta nessun comitato selezionato.
            </div>
        <?php } ?>
        <?php if ( isset($_GET['comitato']) ) { ?>
            <div class="alert alert-danger">
                <i class="icon-ban-circle"></i> <strong>Errore date</strong>.
                Le date e gli orari inseriti non sono nel formato corretto.
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
                    <h2><i class="icon-warning-sign muted"></i> Impossibile inserire la propria disponiblità</h2>
                    <div class="alert alert-error">
                        <div class="row-fluid">
                            <span class="span12">
                                <p>Ci dispiace ma non puoi inserire la tua disponibilità finchè il tuo trasferimento è pendente.</p>
                            </span>
                        </div>
                    </div>           
                </div>  
                <?php $i=2; } } }
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
                                <p>Rimarrai nel ruolo di riserva fino al <strong> <?php echo date('d-m-Y', $riserva->fine); ?></strong> alla fine di tale periodo potrai fornire la tua <strong>reperibilità</strong>.</p>
                            </span>
                        </div>
                    </div>           
                </div>
                <?php $x=1; }}
                if($x==0) {
                    if($i==0){ ?>
                    <div class="row-fluid">
                        <h2><i class="icon-thumbs-up muted"></i> Reperibilità</h2>
                        <div class="alert alert-block alert-info ">
                            <div class="row-fluid">
                                <span class="span12">
                                    <h4>Vuoi dare la tua disponibilità ?</h4>
                                    <p>Con questo modulo puoi dare la tua disponibilità alla Centrale Operativa per eventuali emergenze</p>
                                    <p>Seleziona il tempo per cui vuoi dare la tua disponibilità e indica il tempo necessario per essere in Centrale Operativa.</p>
                                </span>
                            </div>
                        </div>           
                    </div>
                    
                    <div class="row-fluid">
                        <form class="form-horizontal" action="?p=utente.reperibilita.ok&id=<?php echo $me->id; ?>" method="POST">
                            <?php if ( count($me->comitati()) > 1 ) { ?>
                            <div class="control-group">
                                <label class="control-label" for="inputComitato">Comitato</label>
                                <div class="controls">
                                    <select class="input-xxlarge" id="inputComitato" name="inputComitato"  required>
                                        <?php
                                        foreach ( $me->comitati() as $id ) { ?>
                                        <option value="<?php echo $id; ?>"><?php echo $id->nomeCompleto(); ?></option>
                                        <?php } ?>
                                    </select>   
                                </div>
                            </div>
                            <?php } ?>
                            <div class="control-group">
                                <label class="control-label" for="inizio">Inizio </label>
                                <div class="controls">
                                    <input class="input-medium" type="text" name="inizio" id="inizio" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="fine">Fine </label>
                                <div class="controls">
                                    <input class="input-medium" type="text" name="fine" id="fine" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="attivazione"> Tempo di attivazione</label>
                                <div class="controls">
                                    <input class="input-mini" type="text" name="attivazione" id="attivazione" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                  <button type="submit" class="btn btn-large btn-success">
                                      <i class="icon-ok"></i>
                                      Invia disponibilità
                                  </button>
                              </div>
                          </div>
                      </div>
                      
                      <?php if($me->mieReperibilita()){?>
                      <div class="row-fluid">
                        <h2>
                            <i class="icon-time muted"></i>
                            Mie Reperibilità
                        </h2>
                        
                    </div>
                    
                    <div class="row-fluid">
                        
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Stato</th>
                                <th>Inizio</th>
                                <th>Fine</th>
                                <th>Tempo Attivazione</th>
                                <th>Comitato</th>
                                <th>Azione</th>
                            </thead>
                            
                            <?php foreach ( $me->mieReperibilita() as $app ) { ?>
                            <tr<?php if ($app->attuale()) { ?> class="success"<?php } ?>>
                            <td>
                                <?php if ($app->attuale()) { ?>
                                Attuale
                                <?php } else { ?>
                                Passato
                                <?php } ?>
                            </td>
                            
                            <td>
                                <i class="icon-calendar muted"></i>
                                <?php echo $app->inizio()->inTesto(); ?>
                            </td>
                            
                            <td>
                                <i class="icon-time muted"></i>
                                <?php echo $app->fine()->inTesto(); ?>
                            </td>
                            
                            <td>
                                <i class="icon-time muted"></i>
                                <?php echo $app->attivazione; ?> min
                            </td>
                            
                            <td>
                                <?= $app->comitato()->nomeCompleto(); ?>
                            </td>
                            
                            <?php if ($app->attuale()) { ?>
                            <td>
                                <a class="btn btn-danger" href="?p=utente.reperibilita.cancella&id=<?php echo $app->id; ?>">
                                    <i class="icon-ban-circle"></i>
                                    Rimuovi disponibilità
                                </a>
                            </td>
                            <?php }else{ ?>
                            <td></td>
                            <?php } ?>
                            
                        </tr>
                        <?php } ?>
                        
                    </table>
                </div>
                <?php }?>
                <?php }} ?>
            </div>
        </div>