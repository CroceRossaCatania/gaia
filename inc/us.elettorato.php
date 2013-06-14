<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

?>
<form action="?" method="GET">
    <input type="hidden" name="p" value="us.elettoratoattivo">
<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-time"></i> Data elezioni</h3>
        </div>
    <div class="modal-body">
          <div class="row-fluid">
            <div class="control-group">
                <div class="controls">
                  <input class="input-medium" type="text" name="inputData" id="inputData" required pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}">
                </div>
            </div>
        </div>
    </div>
        <div class="modal-footer">
          <a href="?p=presidente.utenti" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-list"></i> Genera elenchi
          </button>
        </div>
</div>
    
</form>
