<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(array('id'), 'autoparco.veicoli&err');

$mod = null;

if ( isset($_GET['mod']) ){ 

  $mod = "&mod";
  $rifornimento = Rifornimento::id($_GET['id']);
  $rifornimenti = Rifornimento::filtra([['veicolo', $rifornimento->veicolo()]],'data DESC LIMIT 0,5');
  $veicolo      = $rifornimento->id;

}else{

  $veicolo = Veicolo::id($_GET['id']);
  proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);
  $rifornimenti = Rifornimento::filtra([['veicolo', $veicolo]],'data DESC LIMIT 0,5');
  $rifornimento = null;
          
}

if ( $veicolo->fuoriuso() ){
  redirect('autoparco.veicoli&giaFuori');
}

?>
<form class="form-horizontal" action="?p=autoparco.veicolo.rifornimento.nuovo.ok&id=<?= $veicolo; ?><?= $mod; ?>" method="POST">
  <div class="modal fade automodal">
    <div class="modal-header">
      <h3><i class="icon-credit-card"></i> Rifornimenti veicolo</h3>
    </div>
    <div class="modal-body">
      <div class="row-fluid">
        <div class="control-group">
          <label class="control-label" for="inputKm">Km</label>
          <div class="controls">
            <input class="input-medium" type="text" name="inputKm" id="inputKm" placeholder="150000" required value="<?= $rifornimento->km; ?>">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputData">Data</label>
          <div class="controls">
            <input class="input-medium" type="text" name="inputData" id="inputData" placeholder="01/10/2014" required value="<?php if ($rifornimento) echo date('d/m/Y', $rifornimento->data); ?>">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputLitri">Litri</label>
          <div class="controls">
            <input class="input-medium" type="number" step="0.01" name="inputLitri" id="inputLitri" placeholder="50" required value="<?= $rifornimento->litri; ?>">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputCosto">Costo</label>
          <div class="controls">
            <input class="input-medium" type="number" step="0.01" name="inputCosto" id="inputCosto" placeholder="15,00" required value="<?= $rifornimento->costo; ?>"> <span class="add-on"><i class="icon-euro"></i></span>
          </div>
        </div>
        <hr/>
        <h4>Ultimi 5 Rifornimenti<?php if(!isset($_GET['mod'])){ ?><a href="?p=autoparco.veicolo.rifornimenti&id=<?= $veicolo; ?>" class="btn btn-small pull-right"> Visualizza tutti
                                </a><?php } ?></h4>
        <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
          <thead>
              <th>Km</th>
              <th>Data</th>
              <th>Litri</th>
              <th>Costo</th>
          </thead>
          <?php 
          foreach($rifornimenti as $riforni){ ?>
            <tr>
                <td><?= $riforni->km; ?></td>
                <td><?= date('d/m/Y', $riforni->data); ?></td>
                <td><?= $riforni->litri; ?></td>
                <td><?= $riforni->costo; ?></td>
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
      