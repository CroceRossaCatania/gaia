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
<form class="form-horizontal" action="?p=autoparco.veicolo.fermotecnico.ok&id=<?= $veicolo; ?>" method="POST">
  <div class="modal fade automodal">
    <div class="modal-header">
      <h3><i class="icon-arrow-right"></i> Fermo tecnico veicolo</h3>
    </div>
    <div class="modal-body">
      <div class="row-fluid">
        <?php if ( $veicolo->fermoTecnico() ){ ?>
          <div class="btn-group btn-group-vertical span12">
            <a href="?p=autoparco.veicolo.fermotecnico.ok&id=<?= $veicolo; ?>" class="btn btn-primary btn-block">
                <i class="icon-link"></i>
                Termina fermo tecnico
            </a>
          </div>
        <?php }else{ ?>
          <div class="control-group">
            <label class="control-label" for="inputMotivo">Motivo</label>
            <div class="controls">
              <input class="input-xlarge" type="text" name="inputMotivo" id="inputMotivo" placeholder="Pneumatico ant dx forato" required>       
            </div>
          </div>
        <?php } ?>
        <hr/>
        <h4>Ultimi 5 Fermi tecnici <a href="?p=autoparco.veicolo.fermitecnici&id=<?= $veicolo; ?>" class="btn btn-small pull-right"> Visualizza tutti
                                </a></h4>
        <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
          <thead>
              <th>Motivo</th>
              <th>Inizio</th>
              <th>Fine</th>
          </thead>
          <?php 
          $fermitecnici = Fermotecnico::filtra([['veicolo', $veicolo]],'inizio DESC LIMIT 0,5');
          foreach($fermitecnici as $fermotecnico){ ?>
            <tr>
                <td><?= $fermotecnico->motivo; ?></td>
                <td><?= $fermotecnico->inizio(); ?></td>
                <td><?= $fermotecnico->fine(); ?></td>
            </tr>
          <?php } ?>  
        </table>
      </div> 
    </div>
    <div class="modal-footer">
      <a href="?p=autoparco.veicoli" class="btn">Annulla</a>
      <button type="submit" class="btn btn-success">
        <i class="icon-save"></i> Registra
      </button>
    </div>
  </div>
</form>
      