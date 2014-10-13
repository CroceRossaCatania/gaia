<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

paginaAdmin();

$minimo  = ( !empty($_GET['minimo']) ? (int) $_GET['minimo'] : 1 );
$massimo = ( !empty($_GET['massimo']) ? (int) $_GET['massimo'] : ERRORIAMICHEVOLI_MINIMO );
$limite  = ( !empty($_GET['limite']) ? (int) $_GET['limite'] : 500 );
if (!empty($_GET['ricErr'])){

//ricerca su tutti gli errori appartenenti ad una richieste o sessione
$errori = MErrore::find([
	'livello'=> [
		'$gte' => $minimo,
		'$lte' => $massimo,
	],
	'$or' =>
		[
			['sessione' => $_GET['ricErr']],
			['richiesta' => $_GET['ricErr']]
		]
])->sort([
	'_id' => -1
])->limit($limite);

} else {

//ricerca su tutti gli errori
$errori = MErrore::find([
	'livello'=> [
		'$gte' => $minimo,
		'$lte' => $massimo,
	]
])->sort([
	'_id' => -1
])->limit($limite);

}
?>

<div class="row-fluid">
	<div class="span7">

		<h3><i class="icon-list"></i> Log degli ultimi errori su Gaia</h3>
	</div>
	<div class="span5">
		<form action="index.php" method="GET">
			<input type="hidden" name="p" value="admin.errori.dettagli" />
			<div class="input-append">
				<input type="text" name="id" placeholder="Codice errore..." class="input-medium" required />
				<button type="submit" class="btn">
					<i class="icon-search"></i> Cerca per id o codice
				</button>
			</div>
		</form>

	</div>
</div>

<hr />

<div class="row-fluid">
	<div class="span3">
		<h4><i class="icon-search"></i> Filtra errori</h4>
	</div>
	<div class="span9">
		<form action="/" method="GET">
			<input type="hidden" name="p" value="admin.errori" />
				Sessione/Richiesta:
				<input type="text" name="ricErr" placeholder="Richiesta o Sessione"  value="<?= $_GET['ricErr']; ?>"/>
				&mdash; Risultati per pagina: &nbsp;
				<input type="number" min="20" max="50000" name="limite" required value="<?= $limite; ?>" />
				<br />
				Minimo livello (<a href="http://www.php.net/manual/en/errorfunc.constants.php" target="_new">ref.</a>):
				<input type="number" min="1" max="4096" name="minimo" required value="<?= $minimo; ?>" />
				&mdash; Massimo livello (<a href="http://www.php.net/manual/en/errorfunc.constants.php" target="_new">ref.</a>):
				<input type="number" min="1" max="4096" name="massimo" required value="<?= $massimo; ?>" />
				<br />
				<button type="submit" class="btn btn-primary">
					<i class="icon-ok"></i>
					Ok
				</button>
		</form>
	</div>
</div>



<table class="table table-condensed table-striped">
	<thead>
		<th>Lv.</th>
		<th>Timestamp</th>
		<th>Messaggio</th>
		<th>Utente</th>
		<th>Locazione</th>
		<th><i class="icon-info-sign"></i></th>
	</thead>

	<?php foreach ( $errori as $e ) { ?>
	<tr class="<?php echo errore_ottieni_classe($e['livello']); ?>">
		<td><i class="<?php echo errore_ottieni_icona($e['livello']); ?>"></i>
		    <?php echo errore_ottieni_testo($e['livello']); ?></td>
		<td><?php echo DT::daTimestamp($e['_id']->getTimestamp())->inTesto(); ?></td>
		<td style="font-size: x-small;"><?php echo $e['messaggio']; ?></td>
		<td><?php if ( $u = $e['utente'] ) { ?>
			<a href="?p=presidente.utente.visualizza&id=<?php echo $u; ?>">
				#<?php echo $u; ?>
			</a>
			<?php } else { ?>
				No
			<?php } ?>
		</td>
		<td style="font-size: x-small;"><?php echo $e['file']; ?>:<?php echo $e['linea']; ?></td>
		<td><a href="?p=admin.errori.dettagli&id=<?php echo $e['_id']; ?>">
			Dettagli
			</a></td>

	</tr>
	<?php } ?>

</table>
