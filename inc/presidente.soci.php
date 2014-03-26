<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);
paginaModale();

?>
<form action="?p=presidente.soci.ok" method="POST">
  <div class="modal fade automodal">
    <div class="modal-header">
      <h3><i class="icon-time"></i> Elenco Soci</h3>
    </div>
    <div class="modal-body">
      <p>Con questo strumento è possibile generare l'elenco soci ad una determinata data.</p>
      <hr />
      <div class="row-fluid">
        <div class="span4 centrato">
            <label class="control-label" for="inputData">Data </label>
        </div>
        <div class="span8">
          <input class="input-large" type="text" name="inputData" id="inputData" required pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" value='<?= date('d/m/Y'); ?>' placeholder='dd/mm/YYYY' />
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <a href="?p=presidente.utenti" class="btn">Annulla</a>
        <button type="submit" class="btn btn-primary" data-attendere="Attendere, generazione in corso...">
          <i class="icon-list"></i> Genera elenco soci
        </button>
    </div>
  </div> 
</form>
