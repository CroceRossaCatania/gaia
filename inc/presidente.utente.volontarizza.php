<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);
controllaParametri(['id']);

$id = $_GET['id']; 
$u = Utente::id($id);
proteggiDatiSensibili($u);

?>
<form action="?p=presidente.utente.volontarizza.ok&id=<?= $u->id; ?>" method="POST">
    <div class="modal fade automodal">
        <div class="modal-header">
          <h3>Volontarizza</h3>
      </div>
      <div class="modal-body">
          <div class="row-fluid">
            <div class="span4 centrato">
                    <label for="dataInizio"><i class="icon-calendar"></i> Inizio</label>
                </div>
                <div class="span8">
                    <input id="dataInizio" class="span12" name="dataInizio" type="text" required />
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <a href="?p=presidente.soci.ordinari" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-hand-up"></i> Volontarizza
          </button>
      </div>
  </div>
</form>
