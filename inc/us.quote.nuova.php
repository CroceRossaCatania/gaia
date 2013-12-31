<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(array('id'), 'us.dash&err');
$id = $_GET['id'];

$v = Volontario::id($id);

proteggiDatiSensibili($v, [APP_SOCI , APP_PRESIDENTE]);

/* 
 * Controllo se ordinario o attivo 
 * e recupero valore della quota minima 
 */
$attivo = false;
if ($v->stato == VOLONTARIO) {
  $attivo = true;
}
$quotaMin = $attivo ? QUOTA_ATTIVO : QUOTA_ORDINARIO;

?>
<form action="?" method="GET">
  <input type="hidden" name="p" value="us.quote.nuova.ok">
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
            <p>Indica la data di registrazione della ricevuta e l'importo, che deve essere superiore a
            <?php echo $quotaMin;?>.00 €.</p>
            <p>L'importo deve essere espresso in cifre, utilizzando il punto come separatore decimale e senza inserire il simbolo dell'Euro (€).
            Ad esempio <?php echo $quotaMin;?>, <?php echo $quotaMin;?>.00 o 19.32 sono importi accettati mentre <?php echo $quotaMin;?>,0 e 19,32 <strong>non</strong> sono importi accettati.</p>
          </div>
        </div>
      </div>
      <div class="row-fluid form-horizontal">
        <div class="control-group">
          <label class="control-label" for="inputData">Data versamento quota</label>
          <div class="controls">
            <input class="input-medium" type="text" name="inputData" id="inputData" required pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}">
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
            <input class="input-medium" type="text" name="inputImporto" id="inputImporto" >
            &nbsp; <span class="muted"> da <?php echo $quotaMin;?>.00€ in su</span>
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
