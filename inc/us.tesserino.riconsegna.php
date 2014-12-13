<?php

/*
* ©2014 Croce Rossa Italiana
*/

controllaParametri(array('id'));

$id = $_GET['id'];
paginaApp([APP_SOCI , APP_PRESIDENTE]);
?>
<form action="?p=us.tesserino.riconsegna.ok&id=<?php echo $id; ?>" method="POST">
    <div class="modal fade automodal">
        <div class="modal-header">
            <h3>Registra riconsegna tesserino</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label for="inputData"><i class="icon-calendar"></i> Data Riconsegna</label>
                </div>
                <div class="span8">
                    <input id="inputData" class="span6" name="inputData" type="text"  required />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="?p=us.tesserini.noRiconsegnati" class="btn">Annulla</a>
            <button type="submit" class="btn btn-success">
                <i class="icon-save"></i> Registra
            </button>
        </div>
    </div>
</form>
