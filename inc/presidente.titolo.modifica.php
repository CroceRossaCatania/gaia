<?php  

$t = $_GET['t'];
$v = $_GET['v'];  
$tp = TitoloPersonale::by('id', $t);
?>
<form action="?p=presidente.titolo.modifica.ok&t=<?php echo $t; ?>&v=<?php echo $v; ?>" method="POST">
<div class="modal fade automodal">
        <div class="modal-header">
          <h3>Modifica Titolo</h3>
        </div>
        <div class="modal-body">
          <p><strong>Compilare solo i campi necessari</strong></p>
          <div class="row-fluid">
                    <div class="span4 centrato">
                        <label for="dataInizio"><i class="icon-calendar"></i> Ottenimento</label>
                    </div>
                    <div class="span8">
                        <input id="dataInizio" class="span12" name="dataInizio" type="text"  value="<?php echo date('d/m/Y', $tp->inizio); ?>" />
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span4 centrato">
                        <label for="dataFine"><i class="icon-time"></i> Scadenza</label>
                    </div>
                    <div class="span8">
                        <input id="dataFine" class="span12" name="dataFine" type="text"  value="<?php echo date('d/m/Y', $tp->fine); ?>" />
                    </div>
                </div>
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
                <div class="row-fluid">
                <div class="span4 centrato">
                        <label for="codice"><i class="icon-barcode"></i> N. Patente</label>
                    </div>
                    <div class="span8">
                        <input id="codice" class="span12" name="codice" type="text" value="<?php echo $tp->codice; ?>" />
                    </div>
                </div>          
        </div>
        <div class="modal-footer">
          <a href="?p=presidente.utente.visualizza&id=<?php echo $v; ?>" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-save"></i> Modifica
          </button>
        </div>
</div>
    
</form>
