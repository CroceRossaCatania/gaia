<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaModale();
$id = $_GET['id'];
$motivo = $_POST['inputMotivo'];
$sessione->motivazione = $motivo;
?>

<div class="modal fade automodal">
	<div class="modal-header">
		<h3><i class="icon-remove"></i> Attenzione</h3>
	</div>
	<div class="modal-body">
		<p>Sei veramente sicuro di voler confermare la negazione di partecipazione a questa attività ?</p>
		<hr />
	</div>
	<div class="modal-footer">
		<a href="?p=attivita.autorizzazioni" class="btn">Annulla</a>
		<a data-autorizzazione="<?php echo $id; ?>" data-accetta="0" class="btn btn-danger">
			<i class="icon-remove"></i> Conferma Negazione
		</a>
	</div>
</div>
    

                            