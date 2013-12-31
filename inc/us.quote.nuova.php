<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(array('id'), 'us.dash&err');
$id = $_GET['id'];

$v = Volontario::id($id);

proteggiDatiSensibili($v, [APP_SOCI , APP_PRESIDENTE]);

?>
<form action="?" method="GET">
  <input type="hidden" name="p" value="us.quote.nuova.ok">
  <div class="modal fade automodal">
    <div class="modal-header">
      <h3><i class="icon-certificate"></i> Pagamento Quota</h3>
    </div>
    <div class="modal-body">
      <div class="row-fluid">
        <div class="span12">
          <div class="alert alert-info">
            <h4>Rinnovo per <?php echo($v->nomeCompleto()); ?></h4>
            <p>Indica la data di registrazione della ricevuta e l'importo, che deve essere superiore a
            8.00 €.</p>
            <p>L'importo deve essere espresso in cifre, utilizzando il punto come separatore decimale e senza inserire il simbolo dell'Euro (€).
            Ad esempio 8, 8.00 o 15.32 sono importi accettati mentre 8,0 e 15,32 <strong>non</strong> sono importi accettati.</p>
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
