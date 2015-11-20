<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();

if (!isset($_POST['operazione'])) {
    redirect('us.tesserini');
}

$tesserini = [];
foreach ( $_POST['selezione'] as $t ) {
	$t = TesserinoRichiesta::id($t);
	if(!$me->admin() && $me->delegazioneAttuale()->comitato() != $t->struttura()) {
	    redirect('errore.permessi&cattivo');
	}
	$tesserini[] = $t;
}
$sessione->selezioneTesserini = json_encode($_POST['selezione']);

switch ( $_POST['operazione'] ) {
	case 'lavora':
		$lavora = true;
		$scarica = false;
		break;
	case 'scarica':
		$lavora = false;
		$scarica = true;
		break;
	case 'lavora-scarica':
		$lavora = $scarica = true;
		break;
	default:
		redirect('errore.permessi&cattivo');
		break;
}
$sessione->operazioneTesserini = $_POST['operazione'];

$n = count($tesserini);
?>

<h2 class="allinea-centro">
	<i class="icon-magic"></i> Operazione su tesserini multipli
</h2>

<hr />

<script type="text/javascript">
function conferma() {
	$("#conferma").hide();
	$("#attendi").show();
	$("#moduloMulti").submit();
}

</script>

<form id="moduloMulti" method="POST" action="?p=us.tesserini.multi.ok"><input type="hidden" name="ok" value="1" /></form>

<div class="row-fluid" id="conferma">
	<div class="span4">
		<h3>Selezionati n. <strong><?= $n; ?></strong></h3>
		<ul>
			<?php foreach ( $tesserini as $t ) { $v = $t->utente(); ?>
				<li>
					<a href="?p=presidente.utente.visualizza&id=<?php echo $v->id; ?>" target="_new">
						<?= $v->nomeCompleto(); ?>
					</a>
				</li>
			<?php } ?>
		</ul>
	</div>
	<div class="span8">
		<h3><i class="icon-warning-sign"></i> Conferma le operazioni</h3>
		<hr />

		<?php if ( $lavora ) { ?>
			<h4>
				<i class="icon-gears"></i>
				Emissione
			</h4>
			<p>Confermando l'operazione, la pratica di tutti i <?= $n; ?> tesserini selezionati verr&agrave; lavorata. Facendo questo, confermi di <strong>aver stampato</strong> correttamente i tesserini. Questa operazione render&agrave; i tesserini <strong>validi</strong>.</p>
			<p>&nbsp;</p>
		<?php } ?>

		<?php if ( $scarica ) { ?>
			<h4>
				<i class="icon-download-alt"></i>
				Scarica
			</h4>
			<p>Confermando l'operazione, tutti i <?= $n; ?> tesserini verranno preparati in formato PDF e scaricati sul tuo computer. <br/>
			<strong>Il tempo stimato per lo scaricamento di <?= $n; ?> tesserini &egrave; di <big><?= ceil($n*TESSERINI_SECONDI/60); ?> minuto/i</big>.</strong><br/>
			<strong>Lo spazio su disco richiesto per i tesserini &egarve; di ca. <?= ceil($n*TESSERINI_MB); ?>MB</big>.</strong><br />
			Assicurati di avere abbastanza tempo e spazio su disco per iniziare l'operazione.
			</p>

			<div class="alert alert-danger alert-block">
				<h4><i class="icon-warning-sign"></i> Attenzione!</h4>
				<p>&Egrave; necessario utilizzare una versione aggiornata di Google Chrome. Lo scaricamento automatico potrebbe non funzionare con altri browser. Chrome pu&ograve; essere scaricato gratuitamente <a href="https://www.google.com/chrome/browser/desktop/index.html?hl=it">da questo collegamento</a>.</p>
				<p>I tesserini verranno scaricati nella cartella impostata per lo scaricamento (generalmente, la cartella "Downloads").</p>
			</div>
			<p>&nbsp;</p>
		<?php } ?>

		<div class="row-fluid">
			<a href="javascript:history.back();" class="span6 btn btn-large">
				<i class="icon-remove"></i> Annulla
			</a>
			<button class="span6 btn btn-large btn-success" onclick="conferma();">
				<i class="icon-ok"></i> Conferma
			</button>

		</div>


	</div>


</div>

<div class="row-fluid" id="attendi" style="display: none;">
	<div class="span8 offset2 allinea-centro">
		<h3><i class="icon-spinner icon-spin"></i> Attendi</h3>
		<p>
			<strong>Non chiudere questa pagina, le operazioni sono in corso.</strong>
		</p>
		<?php if ( $scarica ) { ?>
			<p>Tutti i <?= $n; ?> tesserini sono in preparazione. Non chiudere questa pagina o usare questa finestra per navigare verso altri siti web o pagine.</p>
			<?php if ( $n > 50 ) { ?>
			<div class="alert alert-danger alert-block">
				<h4><i class="icon-warning-sign"></i> Nota bene</h4>
				<p>La selezione attuale contiene pi&ugrave; di 50 tesserini. Potrebbe volerci del tempo.</p>
			</div>
			<?php } ?>
			<p><strong>Al termine della preparazione, lo scaricamento inizier&agrave; automaticamente.</strong></p>

		<?php } ?>		
	</div>
</div>
