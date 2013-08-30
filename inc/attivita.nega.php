<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaModale();
$id = $_GET['id'];
?>
<form action="?p=attivita.nega.ok&id=<?php echo $id; ?>" method="POST">
<div class="modal fade automodal">
	<div class="modal-header">
		<h3><i class="icon-remove"></i> Specifica la motivazione di negazione</h3>
	</div>
	<div class="modal-body">
		<p>Inserisci una motivazione per cui stai negando la partecipazione a questa attivita.</p>
		<hr />
		<div class="row-fluid">
			<div class="span4 centrato">
				<label class="control-label" for="inputMotivo">Motivo</label>
			</div>
			<div class="span8">
				<input class="input-xlarge" type="text" name="inputMotivo" id="inputMotivo" required placeholder="Es: Non in posseso dei requisiti necessari" />
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<a href="?p=attivita.autorizzazioni" class="btn">Annulla</a>
		<button type="submit" class="btn btn-primary">
              <i class="icon-remove"></i> nega
          </button>
	</div>
</div>
    
</form>
                            