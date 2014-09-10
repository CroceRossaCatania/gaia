<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);
controllaParametri(['id'], 'autoparco.veicoli&err');
$veicolo = $_GET['id'];
$veicolo = Veicolo::id($veicolo);

if ( $veicolo->fuoriuso() ){
  redirect('autoparco.veicoli&giaFuori');
}

proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

?>
<div class="row-fluid">
    <?php if (isset($_GET['err'])) { ?>
        <div class="alert alert-block alert-error">
            <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
            <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
        </div> 
    <?php } ?>
    <h2><i class="icon-wrench muted"></i> Registra nuova manutenzione</h2>
    <div class="alert alert-block alert-info ">
        <div class="row-fluid">
            <span class="span12">
                <p>Con questo modulo si possono registrare gli interventi di <b>manutenzione</b>, curati di inserire le informazioni con <b>attenzione</b>.</p>
                <p>Le tipologie di manutenzione sono:
                    <ul>
                        <li>
                            <b>Ordinaria</b> si intende tutti gli interventi in programma;
                        </li>
                        <li>
                            <b>Straordinaria</b> manutenzione improvvisa;
                        </li>
                        <li> 
                            <b>Revisione</b> serve a registrare le revisioni dei veicoli;
                        </li>
                    </ul>
                </p>
            </span>
        </div>
    </div>           
</div>
<form class="form-horizontal" action="?p=autoparco.veicolo.manutenzione.nuovo.ok&id=<?= $veicolo; ?>" method="POST">
    <div class="row-fluid">
        <div class="span6">
            <h3>Manutenzione</h3>
            <div class="control-group">
                <label class="control-label" for="inputTipo">Tipo manutenzione</label>
                <div class="controls">
                    <select class="input-large" id="inputTipo" name="inputTipo"  required class="disabled">
                    <?php foreach ( $conf['man_tipo'] as $numero => $gruppo ) { ?>
                        <option value="<?php echo $numero; ?>"><?php echo $gruppo; ?></option>
                    <?php } ?>
                    </select>   
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputKm">Km</label>
                <div class="controls">
                    <input class="input-large" type="text" name="inputKm" id="inputKm" placeholder="151000" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputData">Data</label>
                <div class="controls">
                    <input class="input-medium" type="text" name="inputData" id="inputData" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputDescrizione">Descrizione</label>
                <div class="controls">
                    <textarea rows="7" class="input-xlarge" name="inputDescrizione" id="inputDescrizione" required></textarea>
                </div>
            </div>
        </div>
        <div class="span6">
            <h3>Manutentore</h3>
            <div class="control-group">
                <label class="control-label" for="inputAzienda">Azienda</b></label>
                <div class="controls">
                    <input class="input-large" type="text" name="inputAzienda" id="inputAzienda" placeholder="Autoriparato"s>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputFattura">Numero fattura</label>
                <div class="controls">
                    <input class="input-small" type="text" name="inputFattura" id="inputFattura" placeholder="1752/14">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputCosto">Costo </label>
                <div class="controls">
                    <div class="input-append">
                        <input class="span6" type="number" name="inputCosto" id="inputCosto" step="0.01" placeholder="3300,00"><span class="add-on"><i class="icon-euro"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
          <button type="submit" class="btn btn-large btn-success">
              <i class="icon-ok"></i>
              Salva manutenzione
          </button>
        </div>
    </div>
</form>