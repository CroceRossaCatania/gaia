<?php

/*
 * ©2014 Croce Rossa Italiana
 */


paginaApp([APP_PRESIDENTE, APP_AUTOPARCO]);

?>

<form action="?p=autoparco.nuovo.ok" method="POST">

  <input type="hidden"/>
  
    <div class="row-fluid">
    
      <div class="span8">
        <h3><i class="icon-plus muted"></i> Nuovo Autoparco</h3>
      </div>
    
      <div class="span4">
        <button type="submit" class="btn btn-large btn-block btn-success">
          <i class="icon-save"></i>
          Salva le informazioni
        </button>
      </div>
    </div>
    <hr/>
    <div class="row-fluid">
      <div class="span7">
        <h3>Dettagli autoparco</h3>
        
        <div class="form-horizontal">
          <div class="control-group">
            <label class="control-label" for="inputNome">Nome autoparco</label>
            <div class="controls">
              <input type="text" class="input-xlarge" name="inputNome" id="inputNome" required>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inputTelefono">Telefono</label>
            <div class="controls">
              <input type="text" name="inputTelefono" id="inputTelefono">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="inputComitato">Comitato</label>
              <div class="controls">
                <select class="input-large" id="inputComitato" name="inputComitato" required>
                    <?php
                    foreach ( $me->comitatiApp ([ APP_AUTOPARCO, APP_PRESIDENTE ]) as $comitato ) { ?>
                        <option value="<?= $comitato->oid(); ?>"><?= $comitato->nomeCompleto(); ?></option>
                    <?php } ?>
                </select>   
              </div>
          </div>

        </div>
      </div>
      
      <div class="span5">
        
        <h3>Localizza autoparco</h3>
        <div class="form-horizontal">

          <div class="control-group">
            <label class="control-label" for="inputIndirizzo">Indirizzo * </label>
            <div class="controls">
              <input type="text" name="inputIndirizzo" id="inputIndirizzo" required />
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inputCivico">Numero civico * </label>
            <div class="controls">
              <input type="text" class="input-mini" name="inputCivico" id="inputCivico" />
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inputCAP">CAP * </label>
            <div class="controls">
              <input type="text" class="input-small" name="inputCAP" id="inputCAP" required />
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inputComune">Comune * </label>
            <div class="controls">
              <input type="text" name="inputComune" id="inputComune" required  />
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inputProvincia">Provincia * </label>
            <div class="controls">
              <input type="text" name="inputProvincia" id="inputProvincia" required />
            </div>
          </div>
          
        </div>
        
      </div>
      
    </div>

  </form>