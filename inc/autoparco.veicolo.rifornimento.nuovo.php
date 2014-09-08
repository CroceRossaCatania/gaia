<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(array('id'), 'autoparco.veicoli&err');
$veicolo = $_GET['id'];
$veicolo = Veicolo::id($veicolo);

if ( $veicolo->fuoriuso() ){
  redirect('autoparco.veicoli&giaFuori');
}

proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

?>
<form class="form-horizontal" action="?p=autoparco.veicolo.rifornimento.nuovo.ok&id=<?= $veicolo; ?>" method="POST">
  <div class="modal fade automodal">
    <div class="modal-header">
      <h3><i class="icon-credit-card"></i> Rifornimenti veicolo</h3>
    </div>
    <div class="modal-body">
      <div class="row-fluid">
        <div class="control-group">
          <label class="control-label" for="inputKm">Km</label>
          <div class="controls">
            <input class="input-medium" type="text" name="inputKm" id="inputKm" placeholder="150000" required>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputData">Data</label>
          <div class="controls">
            <input class="input-medium" type="text" name="inputData" id="inputData" placeholder="01/10/2014" required>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputLitri">Litri</label>
          <div class="controls">
            <input class="input-medium" type="number" step="0.01" name="inputLitri" id="inputLitri" placeholder="50" required>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputCosto">Costo</label>
          <div class="controls">
            <input class="input-medium" type="number" step="0.01" name="inputCosto" id="inputCosto" placeholder="15,00" required> <span class="add-on"><i class="icon-euro"></i></span>
          </div>
        </div>
        <hr/>
        <h4>Ultimi 5 Rifornimenti<a href="?p=autoparco.veicolo.rifornimenti&id=<?= $veicolo; ?>" class="btn btn-small pull-right"> Visualizza tutti
                                </a></h4>
        <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
          <thead>
              <th>Km</th>
              <th>Data</th>
              <th>Litri</th>
              <th>Costo</th>
          </thead>
          <?php 
          $rifornimenti = Rifornimento::filtra([['veicolo', $veicolo]],'data DESC LIMIT 0,5');
          foreach($rifornimenti as $rifornimento){ ?>
            <tr>
                <td><?= $rifornimento->km; ?></td>
                <td><?= date('d/m/Y', $rifornimento->data); ?></td>
                <td><?= $rifornimento->litri; ?></td>
                <td><?= $rifornimento->costo; ?></td>
            </tr>
          <?php } ?>  
        </table>
      </div> 
    </div>
    <div class="modal-footer">
      <a href="?p=autoparco.veicoli" class="btn">Annulla</a>
      <button type="submit" class="btn btn-success">
        <i class="icon-save"></i> Salva
      </button>
    </div>
  </div>
</form>
      