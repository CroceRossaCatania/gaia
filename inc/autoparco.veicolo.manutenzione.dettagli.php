<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);
controllaParametri(['id'], 'autoparco.veicoli&err');
$manutenzione = $_GET['id'];
$manutenzione = Manutenzione::id($manutenzione);
$veicolo = $manutenzione->veicolo();

proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

?>
<div class="row-fluid">
    <div class="span5">
        <h2><i class="icon-wrench muted"></i> Dettagli manutenzione</h2>   
    </div>
    <div class="span3">
        <div class="span12">
            <a href="?p=autoparco.veicolo.manutenzione&id=<?= $veicolo; ?>" class="btn btn-block ">
                <i class="icon-reply"></i> Torna indietro
            </a>
        </div>
    </div>     
    <div class="span4">
    </div>  
</div>
<hr/>
<form class="form-horizontal" action="?p=autoparco.veicolo.manutenzione.nuovo.ok&id=<?= $veicolo; ?>" method="POST">
    <div class="row-fluid">
        <div class="span6">
            <h3>Manutenzione</h3>
            <div class="control-group">
                <label class="control-label" for="inputTipo">Tipo manutenzione</label>
                <div class="controls">
                    <input class="input-large" type="text" name="inputTipo" id="inputTipo" readonly value="<?= $conf['man_tipo'][$manutenzione->tipo]; ?>">  
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputKm">Km</label>
                <div class="controls">
                    <input class="input-large" type="text" name="inputKm" id="inputKm" readonly value="<?= $manutenzione->km; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputData">Data</label>
                <div class="controls">
                    <input class="input-medium" type="text" name="inputData" id="inputData" readonly value="<?= date('d/m/Y', $manutenzione->tIntervento); ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputDescrizione">Descrizione</label>
                <div class="controls">
                    <textarea class="input-xlarge" name="inputDescrizione" id="inputDescrizione" readonly><?= $manutenzione->intervento; ?></textarea>
                </div>
            </div>
        </div>
        <div class="span6">
            <h3>Manutentore</h3>
            <div class="control-group">
                <label class="control-label" for="inputAzienda">Azienda</b></label>
                <div class="controls">
                    <input class="input-large" type="text" name="inputAzienda" id="inputAzienda" readonly value="<?= $manutenzione->azienda(); ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputFattura">Numero fattura</label>
                <div class="controls">
                    <input class="input-medium" type="text" name="inputFattura" id="inputFattura" readonly value="<?= $manutenzione->fattura(); ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputCosto">Costo </label>
                <div class="controls">
                    <div class="input-append">
                        <input class="span6" type="text" name="inputCosto" id="inputCosto" readonly value="<?= $manutenzione->costo; ?>"><span class="add-on"><i class="icon-euro"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>