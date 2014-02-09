<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

paginaAdmin();

$errori = MErrore::find()->sort(['_id' => -1])->limit(500);

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
					<i class="icon-search"></i> Cerca per codice
				</button>
			</div>
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
