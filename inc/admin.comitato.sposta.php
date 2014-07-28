<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
paginaModale();
$t = GeoPolitica::daOid($_GET['oid']);
$estensione = $t->_estensione();
if($estensione==EST_UNITA){
	$elenco = Locale::elenco('nome ASC');
}elseif($estensione==EST_LOCALE){
	$elenco = Provinciale::elenco('nome ASC');
}elseif($estensione==EST_PROVINCIALE){
	$elenco = Regionale::elenco('nome ASC');
}
?>

<form action="?p=admin.comitato.sposta.ok&oid=<?= $_GET['oid']; ?>" method="POST">
	<div class="modal fade automodal">
		<div class="modal-header">
			<h3><i class="icon-arrow-right"></i> Sposta Comitato</h3>
		</div>
		<div class="modal-body">
			<p>Con questo strumento è possibile spostare il Comitato selezionato e tutti i suoi figli!</p>
			<p><strong class="text-error"><i class="icon-warning-sign"></i> Attenzione verrà spostato il Comitato e tutto ciò dipenda da lui.</strong></p>
			<hr />
			<div class="row-fluid">
				<div class="row-fluid">
					<div class="span12 allinea-centro">
						<label class="control-label" for="inputComitato">Seleziona un Comitato</label>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
						<select class="input-xxlarge" id="inputComitato" name="inputComitato" required>
							<?php foreach ( $elenco as $numero ) { ?>
								<option value="<?php echo $numero->oid(); ?>"><?php echo $numero->nomeCompleto(); ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="?p=admin.comitati" class="btn">Annulla</a>
			<button type="submit" class="btn btn-success" >
				<i class="icon-arrow-right"></i> Sposta Comitato
			</button>
		</div>
	</div>
</form>