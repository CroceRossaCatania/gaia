<?php

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(array('id'), 'gruppi.dash&err');

$gruppo = $_GET['id'];
$gruppo = Gruppo::id($gruppo);

proteggiClasse($gruppo, $me);

?>
<form action="?p=gruppo.modifica.ok" method="POST">

<input type="hidden" name="id" value="<?= $gruppo->id; ?>" />

    <div class="modal fade automodal">
            <div class="modal-header">
              <h3><i class="icon-group"></i> Modifica gruppo</h3>
            </div>
            <div class="modal-body">
              <div class="row-fluid">
                    <div class="span4 centrato">
                        <label class="control-label" for="inputNome"> Nome Gruppo</label>
                    </div>
                    <div class="span8">
                      <input value="<?= $gruppo->nome; ?>"class="input-medium" type="text" name="inputNome" id="inputNome" required>
                    </div>
            </div>
            </div>
            <div class="modal-footer">
                <a href="?p=gruppi.dash" class="btn">Annulla</a>
                <button type="submit" class="btn btn-success">
                    <i class="icon-save"></i> Modifica gruppo
                </button>
            </div>
    </div>
    
</form>
