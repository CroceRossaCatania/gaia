<?php  

$a = $_GET['a'];
$h = $_GET['h'];
?>
<form action="?p=attivita.pagina.commento.ok&a=<?php echo $a; ?>&h=<?php echo $h; ?>" method="POST">
<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-comment"></i> Nuovo commento</h3>
        </div>
        <div class="modal-body">
          <div class="row-fluid">
                    <div class="span12">
                        <input id="inputCommento" class="span12" name="inputCommento" type="text"  placeholder="Inserisci un commento qui.."/>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <a href="?p=attivita.pagina&a=<?php echo $a; ?>" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-comment"></i> Commenta
          </button>
        </div>
</div>
    
</form>
