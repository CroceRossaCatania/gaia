<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();
paginaModale();
?>

<form class="form-horizontal" action="?p=admin.ricerca.attivita.ok" method="POST">
  <div class="modal fade automodal">
    <div class="modal-header">
      <h3><i class="icon-calendar"></i> Cerca ID o Nome</h3>
    </div>
    <div class="modal-body">
      <?php if(isset($_GET['no'])) { ?>
        <div class="alert alert-danger">
        <h4><i class="icon-warning-sign"></i> ID o Nome non presenti</h4>
        </div>
      <?php } ?>
      <div class="row-fluid">
        <div class="span4 centrato">
          <label class="control-label" for="input">ID/Nome</label>
        </div>
        <div class="span8">
          <input class="input-medium" type="text" name="input" id="input" autofocus required>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <a href="?p=utente.me" class="btn">Annulla</a>
      <button type="submit" class="btn btn-success">
        <i class="icon-search"></i> Cerca
      </button>
    </div>
  </div>
</form>