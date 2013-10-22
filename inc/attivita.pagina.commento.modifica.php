<?php  

paginaPrivata();
$a = $_GET['id'];
$c = Commento::id($a);
?>
<form action="?p=attivita.pagina.commento.modifica.ok&id=<?php echo $c; ?>" method="POST">
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
          <a href="?p=attivita.pagina&id=<?php echo $c->attivita; ?>" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-edit"></i> Modifica
          </button>
        </div>
</div>
    
</form>
