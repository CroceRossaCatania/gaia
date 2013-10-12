<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
$id = $_GET['id'];
$q = Quota::by('id', $id);
?>
<script type="text/javascript"><?php require './js/us.quote.nuova.js'; ?></script>
<form action="?p=us.quote.modifica.ok" method="POST">
  <input type="hidden" name="id" value="<?= $id; ?>" />
  <div class="modal fade automodal">
    <div class="modal-header">
      <h3><i class="icon-certificate"></i> Modifica quota</h3>
    </div>
    <div class="modal-body">
      <div class="row-fluid form-horizontal">
        <div class="control-group">
          <label class="control-label" for="inputData">Data versamento quota</label>
          <div class="controls">
            <input class="input-medium" type="text" name="inputData" id="inputData" value="<?php echo date('d/m/Y', $q->timestamp); ?>" required pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}">
          </div>
        </div> 
        <div class="control-group">
            <label class="control-label" for="inputQuota">Quota</label>
            <div class="controls">
                <select class="input-large" id="inputQuota" name="inputQuota">
            <?php
                    foreach ( $conf['quote'] as $numero => $quota ) { ?>
                        <option value="<?php echo $numero; ?>" <?php if ( $numero == $q->quota ) { ?>selected<?php } ?>><?php echo $quota; ?></option>
                <?php } ?>
            </select>   
        </div>
      </div>

            <div class="control-group">
                <label class="control-label" id="causale" for="inputCausale" style="display: none" value="<?php echo $q->causale; ?>">Causale</label>
                <div class="controls">
                  <input class="input-large" type="text" name="inputCausale" id="inputCausale" style="display: none">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" id="importo" for="inputImporto" style="display: none" value="<?php echo $q->quota; ?>">Importo</label>
                <div class="controls">
                  <input class="input-medium" type="text" name="inputImporto" id="inputImporto" style="display: none">
                </div>
            </div>


           <input type="hidden" name="id" value="<?php echo $id; ?>">
        </div>
    </div>
        <div class="modal-footer">
          <a href="?p=us.quoteNo" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-list"></i> Registra quota
          </button>
        </div>
</div>
</form>
