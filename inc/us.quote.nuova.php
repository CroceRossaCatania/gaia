<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
$id = $_GET['id'];

?>
<form action="?" method="GET">
    <input type="hidden" name="p" value="us.quote.nuova.ok">
<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-certificate"></i> Pagamento quota</h3>
        </div>
    <div class="modal-body">
          <div class="row-fluid form-horizontal">
            <div class="control-group">
                <label class="control-label" for="inputData">Data versamento quota</label>
                <div class="controls">
                  <input class="input-medium" type="text" name="inputData" id="inputData" required pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputQuota"> Importo quota </label>
                <div class="controls">
                    <div class="btn-group" data-toggle="buttons-radio">
                        <button data-toggle="button" type="button" class="btn btn-primary"><?php echo 'Prima Iscrizione' , ' - ',  QUOTA_PRIMO , '€'; ?></button>
                        <button data-toggle="button" type="button" class="btn btn-primary"><?php echo 'Rinnovo' , ' - ' , QUOTA_RINNOVO , '€'; ?></button>
                        <button data-toggle="button" type="button" class="btn btn-primary">Altro</button>
                    </div>
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
