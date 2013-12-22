<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
paginaModale();
$v = $_GET['id'];
echo $v;
?>

<form action="?p=admin.password.nuova.ok&id=<?= $v; ?>" method="POST">
<div class="modal fade automodal">
        <div class="modal-header">
          <h3><i class="icon-eraser"></i> Cambia Password</h3>
        </div>
    <div class="modal-body">
        <p>Con questo strumento è possibile cambiare la password di un dato utente</p>
        <hr />
          <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputPassword"><strong>Nuova</strong> Password </label>
                </div>
                <div class="span8">
                  <input class="input-large" type="password" name="inputPassword" id="inputPassword" required pattern=".{8,15}" />
                </div>
        </div>
        <div class="row-fluid">
                <div class="span4 centrato">
                    <label class="control-label" for="inputPassword2"><strong>Ripeti Nuova</strong> Password </label>
                </div>
                <div class="span8">
                  <input class="input-large" type="password" name="inputPassword2" id="inputPassword2" required pattern=".{8,15}" />
                </div>
        </div>
    </div>
        <div class="modal-footer">
          <a href="?p=presidente.utenti" class="btn">Annulla</a>
          <button type="submit" class="btn btn-success" >
              <i class="icon-ok"></i> Cambia Password
          </button>
        </div>
</div>
    
</form>
