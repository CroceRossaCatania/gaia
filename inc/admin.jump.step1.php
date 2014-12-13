<?php

paginaAdmin();

$volontari = $_POST['volontari'];
$volontari = explode("\n", $volontari);
sort($volontari);

?>

<h3>Jump &mdash; Step 1</h3>
<h4>Conferma dettagli</h4>

<form action="?p=admin.jump.step2" method="POST">
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<th>Codice Fiscale</th>
		<th>ID#</th>
		<th>Nome completo</th>
		<th>Stato richiesta</th>
		<th>Fototessera</th>
	</thead>

	<tbody>

	<?php

	$saltati 		= 0;
	$inesistenti	= 0;
	$duplicati 		= 0;
	$esistenti 		= [];

	foreach ( $volontari as $v ) { 

		$v = maiuscolo($v);

		if ( !$v ) {
			$saltati++;
			continue;
		}

		$v = Utente::by('codiceFiscale', $v);

		if ( !$v ) {
			$saltati++;
			$inesistenti++;
			continue;
		}

		if ( array_key_exists($v->id, $esistenti) ) {
			$saltati++;
			$duplicati++;
			continue;
		}

		$esistenti[$v->id] = true;

		$r = $v->tesserinoRichiesta();
		$f = $v->fototessera();

		?>

		<tr>
			<td style="font-family: monospace;"><?= $v->codiceFiscale; ?></td>
			<td><?= $v->id; ?></td>
			<td><?= $v->nomeCompleto(); ?></td>
			<td><?= $r ? $conf['tesseriniStato'][$r->stato] : "NON RICHIESTO"; ?></td>
			<td style="font-weight: bold;">
				<?php
				if ( $f ) { ?>

					<?php if ( !$f->approvata() ) { ?>

						<input type="hidden" name="pending[]" value="<?= $v->id; ?>" />
						<i class="icon-ok text-success"></i> Fototessera sottomessa<br />
						<label>
							<img src="<?= $f->img(10); ?>" />
							<input type="checkbox" name="volontari[]" value="<?= $v->id; ?>" checked="checked" />
							Approva fototessera (<a target="_blank" href="<?= $f->img(80); ?>">ingrandisci</a>)
						</label>

					<?php } else { ?>

						<i class="icon-ok text-success"></i> Fototessera approvata
						<input type="hidden" name="volontari[]" value="<?= $v->id; ?>" />

					<?php } ?>

				<?php } else { ?>

					<i class="icon-remove text-error"></i> Fototessera non caricata

				<?php } ?>
			</td>
		</tr>

	<?php } ?>

	</tbody>
</table>

<big>
	<strong><?= count($volontari); ?></strong> righe sottomesse,<br />
	<strong><?= $saltati; ?></strong> saltati, tra cui:<br />
	<strong><?= $duplicati; ?></strong> CF duplicati,<br />
	<strong><?= $inesistenti; ?></strong> non esistenti,<br />
</big>

<hr />

<button type="submit" class="btn btn-large btn-success">
	Genera tesserini
</button>

</form>