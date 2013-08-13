<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

?>

<div class="span12">
    <h2><i class="icon-beer muted"></i> Importazione automatica dal format CSV</h2>
    <hr />
</div>

<div class="span12">
    <form class="form-horizontal" action="?p=admin.format.ok" method="POST" enctype="multipart/form-data">
        <div class="control-group">
          <label class="control-label" for="inputCSV">File CSV</label>
          <div class="controls">
            <input type="file" id="inputCSV" name="inputCSV">
          </div>
        </div>    
        <div class="control-group">
            <label class="checkbox" for="inputQuote">
                <input type="checkbox" id="inputQuote" name="inputQuote">Segna contestualmente quote come pagate
            </label>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-danger">
                <i class="icon-fire"></i> Importa dati in massa ed invia email
            </button>
            <button name="pass" type="submit" class="btn btn-danger">
                <i class="icon-key"></i> Importa dati in massa e genera password
            </button>
        </div>

    </form>
</div>