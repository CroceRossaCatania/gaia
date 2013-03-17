<?php

$a = new Attivita(@$_GET['id']);

$del = $me->delegazioni(APP_ATTIVITA);
$comitati = $me->comitatiDelegazioni(APP_ATTIVITA);
$domini = $me->dominiDelegazioni(APP_ATTIVITA);

?>

<form action="?p=attivita.nuova.ok" method="POST">
<input type="hidden" name="id" value="<?php echo $a->id; ?>" />
    
<div class="row-fluid">
    
    <div class="span8">
        <h2><i class="icon-bolt"></i> Attività</h2>
    </div>
    
    <div class="span4">
        <button type="submit" name="azione" value="salva" class="btn btn-success btn-block btn-large">
            <?php if ( $a->haPosizione() ) { ?>
            <i class="icon-save"></i> Salva l'attività
            <?php } else { ?>
            <i class="icon-globe"></i> Avanti, inserisci luogo
            <?php } ?>
        </button>
    </div>
    
</div>
    <hr />
<div class="row-fluid">
    <div class="span5">    
            <h3>
                <i class="icon-list-alt muted"></i>
                Dettagli
            </h3>
        
  

          <div class="form-horizontal">
          <div class="control-group">
            <label class="control-label" for="inputNome">Nome</label>
            <div class="controls">
              <input class="input-xlarge" value="<?php echo $a->nome; ?>" type="text" id="inputNome" name="inputNome" placeholder="Es.: Aggiungi un Posto a Tavola" required autofocus pattern=".{2,}" />
            </div>
          </div>          
           
          <div class="control-group">
            <label class="control-label" for="inputReferente">Referente</label>
            <div class="controls">
                <input type="hidden" name="inputReferente" value="<?php echo $me->id; ?>" />
              <input class="input-xlarge" value="<?php echo $me->nome . ' ' . $me->cognome; ?>" type="text" readonly />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputComitato">Organizzatore</label>
            <div class="controls">
                <select required name="inputComitato" id="inputComitato" autofocus class="input-xlarge">
                    <option value="" selected="selected">[ Seleziona un Comitato ]</option>
                    <?php 
                    foreach ( $comitati as $c ) { ?>
                        <option value="<?php echo $c->id; ?>" <?php if ($a->comitato == $c->id ) { ?>selected="selected"<?php }?>><?php echo $c->nome; ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>
        <div class="control-group">
            <label class="control-label">Apertura</label>
            <div class="controls">
                <div class="btn-group" id="privacyGroup">
                    <input type="hidden" name="inputPubblica" id="privacySwitch" value="<?php echo (int) $a->pubblica; ?>" />
                    <button data-value="1" type="button" class="privacy btn <?php if ( $a->pubblica == 1 ) { ?>active<?php } ?>"><i class="icon-globe"></i> Aperto a tutti</button>
                    <button data-value="0" type="button" class="privacy btn <?php if ( $a->pubblica == 0 ) { ?>active<?php } ?>"><i class="icon-lock"></i> Per il Comitato</button>
                </div>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="inputTipo">Tipo attività</label>
            <div class="controls">
                <select required name="inputTipo" id="inputTipo" autofocus class="input-xlarge">
                    <option value="" selected="selected">[ Seleziona una Categoria ]</option>
                    <?php foreach ( $conf['app_attivita'] as $num => $nom ) { 
                        if ( !in_array(APP_ATTIVITA_TUTTO, $domini) && !in_array($num, $domini)) {
                            continue;
                        } ?>
                        <option value="<?php echo $num; ?>"  <?php if ($a->tipo == $num ) { ?>selected="selected"<?php }?>><?php echo $nom; ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputDescrizione">Descrizione</label>
            <div class="controls">
              <textarea rows="10" class="input-xlarge" type="text" id="inputDescrizione" name="inputDescrizione" placeholder="Ulteriori informazioni, dettagli dell'attività, come raggiungere il luogo, ecc." required><?php echo $a->descrizione; ?></textarea>
            </div>
          </div>
          
      
       

        </div>
    

</div>
    
    <div class="span7">
        
        <h3><i class="icon-time muted"></i> Turni</h3>
        
        <div class="alert alert-block alert-info">
            <h4><i class="icon-info-sign"></i> <strong>Minimo e massimo</strong>.</h4>
            <p>Minimo e Massimo ti permettono di specificare il numero minimo e massimo di volontari.</p>
            <p>Un turno con carenza di volontari sarà evidenziato; al contempo uno che ha già il numero
                massimo, non permetterà ulteriori richieste di partecipazione.</p>
        </div>
        
        <table class="table table-striped table-bordered" id="tabellaTurni">
             <thead>
                 <th>Nome</th>
                 <th>Inizio</th>
                 <th>Fine</th>
                 <th>Min vv.</th>
                 <th>Max vv.</th>
             </thead>
             
                 <?php 
                 $t = $a->turni();
                 if ( !$t ) {
                     $x = new Turno();
                     $x->attivita = $a->id;
                     $x->inizio   = time();
                     $x->fine     = strtotime('+2 hours');
                     $x->nome     = 'Turno 1';
                     $x->minimo   = 1;
                     $x->massimo  = 4;
                     $t[] = $x;
                 }
                 foreach ( $t as $_t ) { ?>
                    <tr class="unTurno">
                        <td>
                            <input class="span12" required type="text" name="<?php echo $_t->id; ?>_nome" value="<?php echo $_t->nome; ?>" />
                        </td>
                        <td>
                            <input class="dt span12" required type="text" name="<?php echo $_t->id; ?>_inizio" value="<?php echo $_t->inizio()->format('d/m/Y H:i'); ?>" />
                        </td>
                        <td>
                            <input class="dt span12" required type="text" name="<?php echo $_t->id; ?>_fine" value="<?php echo $_t->fine()->format('d/m/Y H:i'); ?>" />
                        </td>
                        <td>
                            <input class="input-mini" type="number" required min="0" max="999" step="1" name="<?php echo $_t->id; ?>_minimo" value="<?php echo $_t->minimo; ?>" />
                        </td>                        
                        <td>
                            <input class="input-mini" type="number" required min="0" max="999" step="1" name="<?php echo $_t->id; ?>_massimo" value="<?php echo $_t->massimo; ?>" />
                        </td>
                    </tr>
                <?php } ?>
             <tr>
                 <td colspan="5">
                     <button type="submit" name="azione" value="aggiungiTurno" class="btn btn-block btn-primary">
                        <i class="icon-plus"></i>
                        Aggiungi nuovo turno
                     </button>
                 </td>
             </tr>
             
         </table>

        
    </div>
    
<!--Mappa-->    
</div>
</form>