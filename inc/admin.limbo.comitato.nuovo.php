<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
caricaSelettoreComitato();
controllaParametri(array('id'), 'admin.limbo&err');
$t = $_GET['id'];
?>
<form class="form-horizontal" action="?p=admin.limbo.comitato.nuovo.ok&id=<?php echo $t; ?>" method="POST">

    <div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-arrow-right"></i> Assegna ad un Comitato</h3>
      </div>
      <div class="modal-body">
          <div class="row-fluid">
           <div class="control-group">
            <label class="control-label" for="inputComitato">Comitato Destinazione </label>
            <div class="controls">
              <a class="btn btn-inverse" data-selettore-comitato="true" data-input="inputComitato">
                Seleziona un comitato... <i class="icon-pencil"></i>
            </a>
        </div>
    </div>
</div>
<div class="row-fluid">
  <div class="span4 centrato">
  <label class="control-label" for="dataingresso">Data ingresso in CRI </label>
</div>
<div class="span8">
    <input class="input-medium" type="text" name="dataingresso" id="dataingresso" required>
</div>
</div>
</div>
<div class="modal-footer">
    <a href="?p=presidente.utente.visualizza&id=<?= $t ?>" class="btn">Annulla</a>
    <button type="submit" class="btn btn-success">
      <i class="icon-ok"></i> Assegna
  </button>
</div>
</div>

</form>