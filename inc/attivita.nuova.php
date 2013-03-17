<?php
$a = new Attivita(@$_GET['id']);

$del = $me->delegazioni(APP_ATTIVITA);
$dominio = [];

foreach ( $del as $k ) {
    $dominio[] = $k->dominio;
    $comitati[] = $k->comitato();
}
$comitati = array_unique($comitati);

?>

<div class="row-fluid">
    <div class="span6">    
            <h2>
                <i class="icon-list-alt text-info"></i>
                Attività
            </h2>
        
    <div class="alert alert-error alert-block">
        <h4><i class="icon-warning-sign"></i> Altamente sperimentale</h4>
        Potrebbe uccidere il tuo gatto.</p>
    </div>

          <div class="form-horizontal">
          <div class="control-group">
            <label class="control-label" for="inputNome">Nome</label>
            <div class="controls">
              <input class="input-xlarge" value="<?php echo $a->nome; ?>" type="text" id="inputNome" name="inputNome" placeholder="Es.: Aggiungi un Posto a Tavola" required autofocus pattern=".{2,}" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputComitato">A chi è rivolta l'attività</label>
            <div class="controls">
                <select required name="inputComitato" id="inputComitato" autofocus class="input-xlarge">
                    <option value="" selected="selected">[ Seleziona un Comitato ]</option>
                    <?php 
                    foreach ( $comitati as $c ) { ?>
                        <option value="<?php echo $c->id; ?>" <?php if ($a->comitato->id == $c->id ) { ?>selected="selected"<?php }?>><?php echo $c->nome; ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Tipo attività</label>
            <div class="controls">
                <select required name="inputTipo" id="inputTipo" autofocus class="input-xlarge">
                    <option value="" selected="selected">[ Seleziona una Categoria ]</option>
                    <?php foreach ( $me->comitati() as $c ) { ?>
                        <option value="<?php echo $c->id; ?>"><?php echo $c->nome; ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputDescrizione">Descrizione attività</label>
            <div class="controls">
              <textarea rows="7" class="input-xlarge" type="text" id="inputDescrizione" name="inputDesrizione" placeholder="Es.: Attività rivolta agli indigenti" required pattern=".{2,}"></textarea>
            </div>
          </div>
          
      
        <table class="table table-striped table-bordered table-condensed" id="tabellaTurni">
             <thead>
                 <th>Turno</th>
                 <th>Inizio</th>
                 <th>Fine</th>
             </thead>
             <tr>
                     <td></td>
                     <td></td>
                     <td></td>
                 </tr>
             <tr>
                 <td colspan="3"><button id="aggiungiTurno" class="btn btn-block btn-primary">
                   <i class="icon-plus"></i>
                   Aggiungi turno
               </button></td>


             </tr>
         </table>


        </div>
    

</div>
    
    <div class="span6">
        
        <h2><i class="icon-time text-success"></i> Turni</h2>
        
        
        
    </div>
    
<!--Mappa-->    
</div>
