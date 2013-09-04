<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$c = $_GET['id'];
$t = $_GET['t'];
?>

<div class="row-fluid">
            <h2><i class="icon-chevron-right muted"></i> Crea nuovo Comitato</h2>
            <div class="alert alert-block alert-info ">
                <div class="row-fluid">
                    <span class="span7">
                        <p>Con questo modulo si possono aggiungere i Comitati al DB di GAIA</p>
                        <p>Es: Comitato Provinciale di Catania</p>
                    </span>
                </div>
            </div>           
        </div>
<form class="form-horizontal" action="?p=admin.comitato.nuovo.ok&id=<?php echo $c; ?>&<?php echo $t; ?>" method="POST">
  <div class="control-group">
  <label class="control-label" for="inputNome">Nome nuovo Comitato </label>
  <div class="controls">
      <input class="input-xxlarge" type="text" name="inputNome" id="inputNome" placeholder="Comitato Provinciale di Catania" required>
      <br />
      <?php if ($t == "com") { ?>
      <input type="hidden" name="inputPrincipale" value="0" />
      <hr />
      Unita' territoriale: 
        <label>
          <input type="checkbox" name="inputPrincipale" value="1" /> SELEZIONA COME UNITA PRINCIPALE
        </label>
      </div>
      <?php } ?>

    </div>
    <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-large btn-success">
                <i class="icon-ok"></i>
                Crea nuovo Comitato
            </button>
          </div>
        </div>

</form>