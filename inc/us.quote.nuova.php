<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(array('id'), 'us.dash&err');
$id = $_GET['id'];

$v = Utente::id($id);

proteggiDatiSensibili($v, [APP_SOCI , APP_PRESIDENTE]);

/* 
 * Controllo se ordinario o attivo 
 * e recupero valore della quota minima 
 */
$attivo = false;
if ($v->stato == VOLONTARIO) {
  $attivo = true;
}

if (!$t = Tesseramento::attivo()) {
  redirect('us.quoteNo&err');
}

$quotaMin = $attivo ? $t->attivo : $t->ordinario;

?>
<form action="?p=us.quote.nuova.ok" method="POST">
  <input type="hidden" name="vol" value="<?php echo $id; ?>" />
  <div class="modal fade automodal">
    <div class="modal-header">
      <h3><i class="icon-certificate"></i> Pagamento quota <?php echo($attivo ? 'socio attivo' : 'socio ordinario') ?></h3>
    </div>
    <div class="modal-body">
      <div class="row-fluid">
        <div class="span12">
          <?php if(isset($_GET['importo'])) { ?>
            <div class="alert alert-error">
              <h4><i class="icon-warning-sign"></i> Qualcosa non ha funzionato</h4>
              <p>Sembra che tu abbia inserito un importo inferiore a <?php echo $quotaMin;?>.00 €.</p>
            </div>
          <?php } ?>
          <div class="alert alert-info">
            <h4>Rinnovo per <?php echo($v->nomeCompleto()); ?></h4>
            <p>Indica la data di registrazione della ricevuta e l'importo, uguale o superiore a
            <?php echo $quotaMin;?>.00 €.</p>
          </div>
        </div>
      </div>
      <div class="row-fluid form-horizontal">
        <div class="control-group">
          <label class="control-label" for="inputData">Data versamento quota</label>
          <div class="controls">
            <input class="input-medium" type="text" name="inputData" 
            id="inputData" required pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" autocomplete="off"
            data-inizio="<?php echo $t->inizio()->format('d/m/Y'); ?>" data-fine="<?php echo $t->fine()->format('d/m/Y'); ?>"
            />
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="inputAnno">Anno versamento</label>
          <div class="controls">
              <input class="input-large" type="text" name="inputCausale" id="inputCausale" value="<?php echo(date('Y')); ?>" readonly>  
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" id="causale" for="inputCausale" >Causale</label>
          <div class="controls">
            <input class="input-large" type="text" name="inputCausale" id="inputCausale" value="Rinnovo Quota <?php echo(date('Y')); ?>" readonly>
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" id="importo" for="inputImporto" >Importo in €</label>
          <div class="controls">
            <input class="input-medium" type="number" min="<?php echo $quotaMin ?>" value="<?php echo $quotaMin ?>" step="0.01" name="inputImporto" id="inputImporto" >
            &nbsp; <span class="muted"> da <?php echo $quotaMin;?>.00 € in su</span>
          </div>
        </div>
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
