<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_PATENTI , APP_PRESIDENTE]);
paginaModale();

controllaParametri(array('id'), 'patenti.dash&err');

$v = $_GET['id'];
?>
<form action="?p=patenti.richieste.ok&id=<?= $v; ?><?php if ( isset($_GET['visita']) ){ ?>&visita<?php }elseif ( isset($_GET['stampa']) ){ ?>&stampa<?php }elseif ( isset($_GET['consegna']) ){ ?>&consegna<?php } ?>" method="POST">
<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-time"></i> Data <?php if ( isset($_GET['visita']) ){ ?> Visita <?php }elseif ( isset($_GET['stampa']) ){ ?> Stampa <?php }elseif ( isset($_GET['consegna']) ){ ?> Consegna <?php } ?></h3>
        </div>
    <div class="modal-body">
        <p>Inserisci la data <?php if ( isset($_GET['visita']) ){ ?> della visita medica <?php }elseif ( isset($_GET['stampa']) ){ ?> della stampa della patente <?php }elseif ( isset($_GET['consegna']) ){ ?> di consegna della patente <?php } ?></p>
          <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputData">Data </label>
                </div>
                <div class="span8">
                  <input class="input-large" type="text" name="inputData" id="inputData" required pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" value='<?php echo date('d/m/Y'); ?>' placeholder='dd/mm/YYYY' />
                </div>
        </div>
    </div>
        <div class="modal-footer">
          <a href="?p=presidente.utenti" class="btn">Annulla</a>
          <button type="submit" class="btn btn-success">
              <i class="icon-ok"></i> Conferma
          </button>
        </div>
</div>
    
</form>
