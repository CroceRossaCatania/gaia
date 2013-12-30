<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
paginaModale();
controllaParametri(array('id'), 'admin.limbo&err');
$v = $_GET['id'];
?>

<form action="?p=admin.stato.modifica.ok&id=<?php echo $v; ?>" method="POST">
	<div class="modal fade automodal">
		<div class="modal-header">
			<h3><i class="icon-random"></i> Seleziona stato</h3>
		</div>
		<div class="modal-body">
			<p>Con questo strumento è possibile selezionare lo stato dell'utente</p><hr />
			<div class="row-fluid">
				<div class="row-fluid">
					<div class="span12 allinea-centro">
						<label class="control-label" for="inputStato">Seleziona uno stato</label>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
						<select class="input-xxlarge" id="inputStato" name="inputStato" required>
							<?php foreach ( $conf['statoPersona'] as $numero => $tipo ) { ?>
								<option  value="<?php echo $numero; ?>"><?php echo $tipo; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="?p=admin.double" class="btn">Annulla</a>
			<button type="submit" class="btn btn-success" >
				<i class="icon-random"></i> Cambia stato
			</button>
		</div>
	</div>
</form>