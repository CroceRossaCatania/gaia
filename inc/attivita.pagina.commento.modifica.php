<?php  

$a = $_GET['a'];
$c = Commento::by('id', $a);
?>
<form action="?p=attivita.pagina.commento.modifica.ok&a=<?php echo $c; ?>" method="POST">
<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-comment"></i> Modifica commento</h3>
        </div>
        <div class="modal-body">
          <div class="row-fluid">
                    <div class="span12">
                        <input id="inputCommento" class="span12" name="inputCommento" type="text"  value="<?php echo $c->commento; ?>"/>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <a href="?p=attivita.pagina&a=<?php echo $a; ?>" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-edit"></i> Modifica
          </button>
        </div>
</div>
    
</form>
