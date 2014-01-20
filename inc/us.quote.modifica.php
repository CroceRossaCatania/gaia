<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
$id = $_GET['id'];
$q = Quota::by('id', $id);
$u = $q->volontario();
$attivo = false;
if ($u->stato == VOLONTARIO) {
  $attivo = true;
}
if (!$t = Tesseramento::by('anno', $q->anno)) {
  $t = new StdClass();
  $t->attivo = 8;
  $t->ordinario = 16;
}
$quotaMin = $attivo ? $t->attivo : $t->ordinario;
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
          <?php if(isset($_GET['importo'])) { ?>
            <div class="alert alert-error">
              <h4><i class="icon-warning-sign"></i> Qualcosa non ha funzionato</h4>
              <p>Sembra che tu abbia inserito un importo inferiore a <?php echo $quotaMin;?>.00 €.</p>
            </div>
          <?php } ?>
        <div class="control-group">
          <label class="control-label" for="inputData">Data versamento quota</label>
          <div class="controls">
            <input class="input-medium" type="text" name="inputData" id="inputData" value="<?php echo date('d/m/Y', $q->timestamp); ?>" required pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}">
          </div>
        </div> 
        <div class="control-group">
            <label class="control-label" id="importo" for="inputImporto" >Importo</label>
            <div class="controls">
              <input class="input-medium" type="number" min="<?php echo $quotaMin ?>" 
              value="<?php echo $q->quota; ?>" step="0.01" name="inputImporto" id="inputImporto" >
              &nbsp; <span class="muted"> da <?php echo $quotaMin;?>.00 € in su</span>
            </div>
        </div>
           <input type="hidden" name="id" value="<?php echo $id; ?>">
        </div>
    </div>
        <div class="modal-footer">
          <a href="?p=presidente.utente.visualizza&id=<?php echo $u->id; ?>" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-list"></i> Registra quota
          </button>
        </div>
</div>
</form>
