<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaAdmin();

?>

<div class="span4">
    <h2><i class="icon-beer muted"></i> Importazione automatica dal format</h2>
    <hr />
</div>

<div class="span8">
    <form class="form-horizontal" action="?p=admin.caricaFormat.ok" method="POST" enctype="multipart/form-data">
        <div class="control-group">
          <label class="control-label" for="inputCSV">File CSV</label>
          <div class="controls">
            <input type="file" id="inputCSV" name="inputCSV">
          </div>
        </div>    
        <div class="form-actions">
            <button type="submit" class="btn btn-danger">
                <i class="icon-fire"></i> Importa dati in massa ed importuna per email
            </button>
        </div>

    </form>
</div>