<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin()

?>
<div class="row-fluid">
    <?php if (isset($_GET['err'])) { ?>
    <div class="alert alert-block alert-error">
        <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
        <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
    </div> 
    <?php } ?>
    <h2><i class="icon-chevron-right muted"></i> Aggiungi nuovo Donazione</h2>
    <div class="alert alert-block alert-info ">
        <div class="row-fluid">
            <span class="span7">
                <p>Con questo modulo si possono aggiungere le donazioni al DB di GAIA</p>
            </span>
        </div>
    </div>           
</div>
<form class="form-horizontal" action="?p=admin.donazione.nuovo.ok" method="POST">
    <div class="control-group">
        <label class="control-label" for="inputTipo">Tipologia donazione</label>
        <div class="controls">
            <select class="input-large" id="inputTipo" name="inputTipo"  required>
                <option value="" ></option>
                <?php
                foreach ( $conf['donazioni'] as $numero => $gruppo ) { ?>
                <option value="<?php echo $numero; ?>" ><?php echo $gruppo[0]; ?></option>
                <?php } ?>
            </select>   
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="inputNome">Nome donazione </label>
        <div class="controls">
        <input class="input-xxlarge" type="text" name="inputNome" id="inputNome" value="" required>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-large btn-success">
              <i class="icon-ok"></i>
              Aggiungi nuova Donazione
          </button>
      </div>
  </div>

