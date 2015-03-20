<?php

/**
 * (c)2015 Croce Rossa Italiana
 */

$app = (int) $_GET['applicazione'];
$oid = $_GET['oid'];
$c = GeoPolitica::daOid($oid);

paginaApp(APP_PRESIDENTE, [$c]);

?>
<form action="?p=presidente.comitato.dipendenti.delega.ok" method="POST">

	<input type="hidden" name="inputApplicazione" value="<?= $app; ?>" />
	<input type="hidden" name="inputComitato" value="<?= $oid; ?>" />
	
    <div class="modal fade automodal">

        <div class="modal-header">
            <h3><i class="icon-plus"></i> Codice Fiscale del Dipendente</h3>
        </div>

        <div class="modal-body">
            <div class="row-fluid">
            
                <div class="alert alert-info">
                    <i class="icon-pencil"></i> <strong>Perch&eacute; devo inserire il C.F.?</strong>
                    <p>Controlleremo se il Dipendente &egrave; gi&agrave; presente su Gaia.</p>
                    <p>Altrimenti, ti chiederemo di completarne la scheda anagrafica.</p>
                </div>
            </div>
          
            <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputCodiceFiscale">Codice Fiscale</label>
                </div>
                <div class="span8">
                    <input type="text" name="inputCodiceFiscale" id="inputCodiceFiscale" required pattern="[A-Za-z]{6}[0-9]{2}[A-Za-z][0-9]{2}[A-Za-z][0-9]{3}[A-Za-z]" />
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <a href="?p=us.dash" class="btn">Annulla</a>
            <button type="submit" class="btn btn-success">
                <i class="icon-plus"></i> Prosegui
            </button>
        </div>
    </div>
</form>
