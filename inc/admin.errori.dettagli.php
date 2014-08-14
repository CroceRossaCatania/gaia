<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

paginaAdmin();

try {
	$id  = new MongoId($_GET['id']);
} catch (Exception $e) {
	$id = "unacosachenonesiste";
}

try {
	$errore = MErrore::findOne(['$or' =>
		[
			['_id' => $id],
			['codice' => $_GET['id']]
		]
	]);
} catch ( Exception $e ) {
	die("Non nel formato corretto.");
}
if ( !$errore ) {
	die("Errore non trovato.");
}

?>

<div class="row-fluid">
	<div class="span8">
		<h3><i class="icon-info-sign"></i> Dettagli del singolo errore</h3>
	</div>
	<div class="span4">
		<a class="btn btn-large btn-block" href="?p=admin.errori">
			<i class="icon-reply"></i> Torna indietro
		</a>
	</div>
</div>

<table class="table table-bordered table-striped">
	
	<?php foreach ( $errore as $nome => $valore ) { ?>
	<tr>
		<td><?php echo $nome; ?></td>
		<td><pre><?php var_dump($valore); ?></pre></td>
	</tr>
	<?php } ?>

</table>
