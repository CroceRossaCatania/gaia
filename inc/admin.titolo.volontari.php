<?php

/**
 * (c)2015 Croce Rossa Italiana
 */

paginaAdmin();
caricaSelettore();

$t = Titolo::id($_GET['id']);

$tp = TitoloPersonale::filtra([
	['titolo', $t],
	['corso', true, OP_NNULL]
]);

?>

<script type="text/javascript">

function _aggiungicf(codiceFiscale) {
	$("#rimuovi").val($("#rimuovi").val() + "\n" + codiceFiscale);
	$("#rimuovi").focus();
}

</script>

<?php if ( isset($_GET['tot']) ) { ?>

	<div class="alert alert-info">
		<i class="icon-info-sign"></i> <strong>Sono stati aggiunti o rimossi n. <?= (int) $_GET['tot']; ?> elementi.</strong>
	</div>

<?php } ?>


<div class="row-fluid">

	<div class="span7">


		<h3>
			<i class="icon-asterisk text-muted"></i> 
			Gestione volontari certificati 
			(<strong><?= $t->nome; ?></strong>)
		</h3>

		<table class="table table-condensed table-bordered table-striped">
		<thead>
			<th>Volontario</th>
			<th>Ottenimento, scadenza e luogo</th>
			<th>Corso ed esaminatore</th>
			<th><i class="icon-remove"></i></th>
		</thead>
		<tbody>
			<?php foreach ($tp as $_tp) { 
				$v = $_tp->volontario();
				?>
				<tr>
					<td>
						<span style="font-family: monospace;"><?= $v->codiceFiscale; ?></span><br />
						<?= $v->nomeCompleto(); ?>
					</td>
					<td>
						<?php echo date('d-m-Y', $_tp->inizio); ?>
						&mdash;
						<?php echo ($_tp->fine ? date('d-m-Y', $_tp->fine) : 'Attuale'); ?><br />
						<?= $_tp->luogo; ?>
					</td>
					<td>
						<span style="font-family: monospace;"><?= $_tp->corso; ?></span><br />
						<?= $_tp->pConferma()->nomeCompleto(); ?>
					</td>
					<td>
						<a href="javascript:_aggiungicf('<?= $v->codiceFiscale; ?>');">
							<i class="icon-remove"></i>
						</a>
					</td>
				</tr>
			<?php } ?>

		</tbody>
		</table>
	</div>


	<div class="span3">
		<h3><i class="icon-plus"></i> Aggiungi</h3>
		<hr />

		<form action="?p=admin.titolo.volontari.aggiungirimuovi" method="POST">
			<input type="hidden" name="id" value="<?= $t->id; ?>" />

			Codice corso: <input type="text" required name="corso" class="input-small" /><br />
			Data esame: <input type="date" required name="inizio" class="input-medium" /><br />
			Scadenza: <input type="date" name="fine" class="input-medium" /><br />
			Luogo: <input type="text" name="luogo" class="input-medium" /><br />
			Esaminatore: <a data-selettore="true" data-input="pConferma" data-autosubmit="false" class="btn btn-small"><i class="icon-edit"></i> <?= $me->nomeCompleto(); ?></a><br />

			<br />

			<textarea name="codicifiscali" cols="20" rows="15" placeholder="Codici fiscali (1 per riga)"></textarea><br />

			<button type="submit" class="btn btn-success btn-block">
				<i class="icon-plus"></i> Aggiungi
			</button>
		</form>
	</div>

	<div class="span2">
		<h3><i class="icon-minus"></i> Rimuovi</h3>
		<hr />

		<form action="?p=admin.titolo.volontari.aggiungirimuovi" method="POST">
			<input type="hidden" name="id" value="<?= $t->id; ?>" />

			<textarea id="rimuovi" name="codicifiscali" cols="15" rows="22" style="font-size: smaller;" placeholder="Codici fiscali (1 per riga)"></textarea><br />

			<button type="submit" class="btn btn-danger btn-block">
				<i class="icon-minus"></i> Rimuovi
			</button>
		</form>
	</div>

</div>