<?php

paginaAdmin();

$volontari = $_POST['volontari'];
$pending   = $_POST['pending'];
if ( !$pending ) {
	$pending = [];
}

$links = [];
?>

<h3>Jump &mdash; Step 2</h3>
<h4>Conferma dettagli</h4>

<table class="table table-condensed table-striped">
	<thead>
		<th>ID#</th>
		<th>CF</th>
		<th>Nome completo</th>
		<th>Tesserino</th>
	</thead>
	<tbody>

<?php

foreach ( $volontari as $v ) {

	$v = Utente::id($v);

	if ( in_array($v->id, $pending) ) {
		$v->fototessera()->approva();
	}

	$r = $v->tesserinoRichiesta();
	if ( !$r ) {
		$r = new TesserinoRichiesta;
		$r->volontario = $v->id;
		$r->timestamp = time();
		$r->pRichiesta = $me->id;
		$r->tRichiesta = time();
		$r->struttura = 'Nazionale:1';
		$r->stato = RICHIESTO;
	}

	?>

	<tr>
		<td><?= $v->id; ?></td>
		<td style="font-family: monospace;"><?= $v->codiceFiscale; ?></td>
		<td><?= $v->nomeCompleto(); ?></td>
		<td><a href="<?php
		$l = "https://gaia.cri.it/?p=us.tesserini.p&id={$r->id}&download";
		$links[] = $l;
		echo $l;
		?>" target="_blank">Richiesta <?= $r->id; ?></a>
		</td>
	</tr>



	<?php

}

?>

</tbody>
</table>

<h3>Links</h3>
<textarea cols="50"><?= implode("\n", $links); ?></textarea>