<?php

/*
 * ©2014 Croce Rossa Italiana
 */

$autoparco = $_GET['id'];
$autoparco = Autoparco::id($autoparco);

paginaApp([APP_PRESIDENTE, APP_AUTOPARCO]);

proteggiAutoparco($autoparco, [APP_AUTOPARCO, APP_PRESIDENTE]);

$admin = $me->admin();

?>

<form action="?p=autoparco.nuovo.ok&id=<?= $autoparco; ?>&mod" method="POST">

  <input type="hidden"/>
  
    <div class="row-fluid">
    
      <div class="span8">
        <h3><i class="icon-plus muted"></i> Dettagli Autoparco</h3>
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
              <input type="text" class="input-xlarge" name="inputNome" id="inputNome" value="<?= $autoparco->nome; ?>" required >
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inputTelefono">Telefono</label>
            <div class="controls">
              <input type="text" name="inputTelefono" id="inputTelefono" value="<?= $autoparco->telefono; ?>">
            </div>
          </div>
          <?php if ( !$admin ) { ?>  
            <div class="control-group">
              <label class="control-label" for="inputComitato">Comitato</label>
              <div class="controls">
                <input class="input-xlarge" type="text" name="inputComitato" id="inputComitato" value="<?= GeoPolitica::daOid($autoparco->comitato)->nomeCompleto(); ?>" readonly>
              </div>
          </div>
          <?php }else{ ?>
            <div class="control-group">
              <label class="control-label" for="inputComitato">Comitato</label>
                <div class="controls">
                  <select class="input-xlarge" id="inputComitato" name="inputComitato" required>
                      <?php
                      foreach ( $me->comitatiApp ([ APP_AUTOPARCO, APP_PRESIDENTE ]) as $comitato ) { ?>
                          <option value="<?= $comitato->oid(); ?>" <?php if ( $comitato->oid() == $autoparco->comitato ) { ?>selected<?php } ?>><?= $comitato->nomeCompleto(); ?></option>
                      <?php } ?>
                  </select>   
                </div>
            </div>
          <?php } ?>

        </div>
      </div>
      
      <div class="span5">
        
        <h3>Localizza autoparco</h3>
        <div class="form-horizontal">

          <div class="control-group">
            <label class="control-label" for="inputIndirizzo">Indirizzo * </label>
            <div class="controls">
              <input type="text" name="inputIndirizzo" id="inputIndirizzo" required value="<?= $autoparco->indirizzo; ?>"/>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inputCivico">Numero civico * </label>
            <div class="controls">
              <input type="text" class="input-mini" name="inputCivico" id="inputCivico" value="<?= $autoparco->civico; ?>"/>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inputCAP">CAP * </label>
            <div class="controls">
              <input type="text" class="input-small" name="inputCAP" id="inputCAP" required value="<?= $autoparco->cap; ?>"/>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inputComune">Comune * </label>
            <div class="controls">
              <input type="text" name="inputComune" id="inputComune" required  value="<?= $autoparco->comune; ?>"/>
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="inputProvincia">Provincia * </label>
            <div class="controls">
              <input type="text" name="inputProvincia" id="inputProvincia" required value="<?= $autoparco->provincia; ?>"/>
            </div>
          </div>
          
        </div>
        
      </div>
      
    </div>

  </form>