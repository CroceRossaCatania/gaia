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
    <h2><i class="icon-chevron-right muted"></i> Aggiungi nuovo Qualifica</h2>
    <div class="alert alert-block alert-info ">
        <div class="row-fluid">
            <span class="span7">
                <p>Con questo modulo si possono aggiungere i Titoli al DB di GAIA</p>
                <p>Es: Laurea in Farmacia</p>
            </span>
        </div>
    </div>           
</div>
<form class="form-horizontal" action="?p=admin.qualifica.nuovo.ok" method="POST">
    <div class="control-group">
        <label class="control-label" for="inputNome">Nome qualifica </label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputNome" id="nome" placeholder="Laurea in Farmacia" required>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="inputNome">Nome Vecchio qualifica </label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="inputNome" id="nome" placeholder="Laurea in Farmacia" required>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-large btn-success">
              <i class="icon-ok"></i>
              Aggiungi nuovo Qualifica
          </button>
      </div>
  </div>

