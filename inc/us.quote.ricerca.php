<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
paginaModale();

?>
<form action="?" method="GET">
  <input type="hidden" name="p" value="us.quote.ricerca.ok">
  <div class="modal fade automodal">
    <div class="modal-header">
      <h3><i class="icon-search"></i> Cerca</h3>
    </div>
    <div class="modal-body">

      <?php if (isset($_GET['nr'])) { ?>
        <div class="alert alert-danger">
          <h4>Quota non trovata</h4>
          <p>La quota ricercata non esiste o ricade al di fuori dei Comitati di tua competenza.</p>
        </div>
      <?php } ?>

      <div class="row-fluid">
        <div class="span4 centrato">
          <label class="control-label" for="inputNumero"> Numero</label>
        </div>
        <div class="span8">
          <input class="input-medium" type="text" name="inputNumero" 
          autofocus id="inputNumero" required />
        </div>
      </div>
      <div class="row-fluid">
        <div class="span4 centrato">
          <label class="control-label" for="inputAnno"> Anno</label>
        </div>
        <div class="span8 input-prepend">
          <span class="add-on"><i class="icon-calendar"></i></span>
          <input class="input-medium" type="number" name="inputAnno" 
          id="inputAnno" value="<?= date('Y'); ?>" required autocomplete="off"
          min="2005" max="<?= date('Y'); ?>"/>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <a href="?p=us.dash" class="btn">Annulla</a>
      <button type="submit" class="btn btn-primary">
        <i class="icon-search"></i> Cerca quota
      </button>
    </div>
  </div>
</form>
