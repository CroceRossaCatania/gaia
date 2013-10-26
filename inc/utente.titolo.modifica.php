<?php  
paginaPrivata();

$t = $_GET['t'];
$tp = TitoloPersonale::id($t);
$r = $tp->titolo()->tipo;
?>
<form action="?p=utente.titolo.modifica.ok&t=<?php echo $t; ?>" method="POST">
<div class="modal fade automodal">
        <div class="modal-header">
          <h3>Modifica Titolo</h3>
        </div>
        <div class="modal-body">
          <div class="row-fluid">
                    <div class="span4 centrato">
                        <label for="dataInizio"><i class="icon-calendar"></i> Ottenimento</label>
                    </div>
                    <div class="span8">
                        <input id="dataInizio" class="span12" name="dataInizio" type="text"  value="<?php if($tp->inizio) echo date('d/m/Y', $tp->inizio); ?>" />
                    </div>
                </div>
         <?php if ($r != TITOLO_STUDIO ) { ?>
                <div class="row-fluid">
                    <div class="span4 centrato">
                        <label for="dataFine"><i class="icon-time"></i> Scadenza</label>
                    </div>
                    <div class="span8">
                        <input id="dataFine" class="span12" name="dataFine" type="text"  value="<?php if($tp->fine) echo date('d/m/Y', $tp->fine); ?>" />
                    </div>
                </div>
          <?php } ?>
          <?php if ( $r == TITOLO_CRI ) { ?>
                <div class="row-fluid">
                    <div class="span4 centrato">
                        <label for="luogo"><i class="icon-road"></i> Luogo</label>
                    </div>
                    <div class="span8">
                        <input id="luogo" class="span12" name="luogo" type="text"  value="<?php echo $tp->luogo; ?>" />
                    </div>
                </div>
                <div class="row-fluid">
                <div class="span4 centrato">
                        <label for="codice"><i class="icon-barcode"></i> Codice</label>
                    </div>
                    <div class="span8">
                        <input id="codice" class="span12" name="codice" type="text" value="<?php echo $tp->codice; ?>" />
                    </div>
                </div>
          <?php } ?>
          <?php if ( $r == TITOLO_PATENTE_CRI ) { ?>
                <div class="row-fluid">
                <div class="span4 centrato">
                        <label for="codice"><i class="icon-barcode"></i> N. Patente</label>
                    </div>
                    <div class="span8">
                        <input id="codice" class="span12" name="codice" type="text" value="<?php echo $tp->codice; ?>" />
                    </div>
                </div>
          <?php } ?>
        </div>
        <div class="modal-footer">
          <a href="?p=utente.titoli&t=<?php echo $r; ?>" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-save"></i> Modifica
          </button>
        </div>
</div>
    
</form>
