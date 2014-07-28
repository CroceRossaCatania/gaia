<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(array('id'), 'autoparco.veicoli&err');
$veicolo = $_GET['id'];
$veicolo = new Veicolo($veicolo);

proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

?>
<form class="form-horizontal" action="?p=autoparco.veicolo.colloca.ok&id=<?= $veicolo; ?>" method="POST">
  <div class="modal fade automodal">
    <div class="modal-header">
      <h3><i class="icon-arrow-right"></i> Colloca in un autoparco</h3>
    </div>
    <div class="modal-body">
      <div class="row-fluid">
        <div class="control-group">
          <label class="control-label" for="inputAutoparco">Comitato</label>
          <div class="controls">
            <select class="input-large" id="inputAutoparco" name="inputAutoparco" required>
              <?php
              foreach ( $me->comitatiApp ([ APP_AUTOPARCO, APP_PRESIDENTE ]) as $comitato ) {
                foreach ( Autoparco::filtra([['comitato', $comitato->oid()]]) as $autoparco ) { ?>
                  <option value="<?= $autoparco; ?>"><?= $autoparco->nome; ?></option>
                <?php } 
              } ?>
            </select>   
          </div>
        </div>
      </div>
      <hr/>
      <h4>Ultime 5 collocazioni <a href="?p=autoparco.veicolo.collocazioni&id=<?= $veicolo; ?>" class="btn btn-small pull-right"> Visualizza tutte
                                </a></h4>
      <table class="table table-striped table-bordered table-condensed" id="tabellaUtenti">
        <thead>
            <th>Autoparco</th>
            <th>Inizio</th>
            <th>Fine</th>
        </thead>
        <?php 
        $collocazioni = Collocazione::filtra([['veicolo', $veicolo]],'inizio DESC LIMIT 0,5');
        foreach($collocazioni as $collocazione){ ?>
          <tr>
              <td><?= $collocazione->autoparco()->nome; ?></td>
              <td><?= $collocazione->inizio(); ?></td>
              <td><?= $collocazione->fine(); ?></td>
          </tr>
        <?php } ?>  
      </table>
    </div>
    <div class="modal-footer">
      <a href="?p=autoparco.veicoli" class="btn">Annulla</a>
      <button type="submit" class="btn btn-success">
        <i class="icon-ok"></i> Colloca
      </button>
    </div>
  </div>
</form>