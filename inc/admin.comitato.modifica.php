<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

controllaParametri(array('oid'), 'admin.comitati&err');
$c = $_GET['oid'];
$c = GeoPolitica::daOid($c);
?>
<form action="?p=admin.comitato.modifica.ok&oid=<?php echo $c->oid(); ?>" method="POST">
<div class="modal fade automodal">
        <div class="modal-header">
          <h3>Modifica Comitato</h3>
        </div>
        <div class="modal-body">
          <div class="row-fluid">
                    <div class="span4 centrato">
                        <label for="inputNome"> Nome</label>
                    </div>
                    <div class="span8">
                        <input id="inputNome" class="span12" name="inputNome" type="text"  value="<?php echo $c->nome; ?>" />
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <a href="?p=admin.comitati" class="btn">Annulla</a>
          <button type="submit" class="btn btn-primary">
              <i class="icon-save"></i> Modifica
          </button>
        </div>
</div>
</form>
