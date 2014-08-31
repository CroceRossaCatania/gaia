<?php

/**
 * (c)2014 Croce Rossa Italiana
 */

?>

<div class="row">

	<div class="span8">
		<h3>
			<i class="icon-rss-sign"></i>
			Aggiornamenti, novit&agrave; e miglioramenti
		</h3>
		<p><strong>Questa pagina raccoglie tutti gli ultimi aggiornamenti, correzioni di errori e miglioramenti che vengono effettuati al software di Gaia dagli sviluppatori.</strong></p>
		<p>Nessun cambiamento viene nascosto &mdash; Crediamo nella filosofia di un progetto aperto, chiunque pu&ograve; accedere al software di Gaia per studiarlo, migliorarlo o per segnalarci criticit&agrave;.</p>
		<p class="alert alert-warning">
			<i class="icon-warning-sign"></i>
			<strong>Nota</strong>: Questa pagina viene generata automaticamente, ogni 60 minuti, attraverso il software usato dagli sviluppatori di Gaia per gestire il progetto.
			Per un elenco tecnico, dettagliato ed in tempo reale, <a href="https://github.com/CroceRossaCatania/gaia/commits/master" target="_blank">clicca qui</a>.
		</p>

		<hr />

		<p class="alert alert-info">
			<i class="icon-info-sign"></i>
			Questa prima tabella elenca gli aggiornamenti pi&ugrave; importanti dell'ultimo mese con la relativa data di pubblicazione.
		</p>
		<table class="table table-condensed table-striped">
			<thead>
				<th>Data aggiornamento</th>
				<th>Oggetto e revisore</th>
				<th>Dettagli</th>
			</thead>
			<tbody>
		<?php
		$elenco 	= ottieniPullRequest();
		$vecchio 	= DT::daTimestamp(time() - MESE);
		foreach ( $elenco as $pull ) { 
			if ( !$pull->merged_at ) { continue; } // Ignora pull request non ancora mergiate.
			$data = new DT($pull->merged_at);
			if ( $data <= $vecchio ) { continue; } // Ignora pull request troppo vecchie
			?>

				<tr>
					<td class="span3" style="font-weight: bold; color: #555;">
						<p>
							<i class="icon-time"></i>
							<?= $data->inTesto(true); ?>
							<br />
							<i class="icon-quote-left"></i>
							Codice #<?= $pull->number; ?>
						</p>
					</td>
					<td class="span6">
						<big><strong><?= $pull->title; ?></strong></big><br />
						Approvato da <a href="<?= $pull->user->url_html; ?>" target="_blank">
							<img src="<?= $pull->user->avatar_url; ?>&size=18" class="img-circle" alt="Avatar di <?= $pull->user->login; ?>" />
							<?= $pull->user->login; ?>
						</a><br />

					</td>
					<td class="span3">
						<a class="btn btn-block" target="_blank"
						   href="<?= $pull->_links->html; ?>">
						   <i class="icon-search"></i> Vedi dettagli
					    </a>

					</td>
				</tr>
				
			<?php } ?>
			</tbody>
		</table>

		<p class="alert alert-info">
			<i class="icon-info-sign"></i>
			Questa tabelle &egrave; molto tecnica ed elenca le ultime contribuzioni degli sviluppatori al codice di Gaia
			(non sono visualizzate le contribuzioni che non sono sono state ancora rilasciate).
		</p>
		<table class="table table-striped">
			<tbody>
		<?php
		$elenco 	= ottieniCommit();
		foreach ( $elenco as $commit ) { 
			$data = new DT($commit->commit->author->date);
			$messaggio = nl2br(str_replace("\n\n", "\n", $commit->commit->message));
			?>

				<tr class="">
					<td class="span3">
						<strong><i class="icon-time icon-large"></i> <?= $data->inTesto(true); ?></strong><br />
						<a href="<?= $commit->author->url_html; ?>" target="_blank">
							<img src="<?= $commit->author->avatar_url; ?>&size=18" class="img-circle" alt="Avatar di <?= $commit->author->login; ?>" />
							<?= $commit->author->login; ?>
						</a>
					</td>
					<td class="span8">
						<?= $messaggio; ?>
					</td>
					<td class="span1">
						<a class="btn btn-block" target="_blank"
						   href="<?= $commit->html_url; ?>">
						   <i class="icon-search"></i>
					    </a>

					</td>
				</tr>
				
			<?php } ?>
			</tbody>
		</table>


	</div>


	<div class="span4">

		<div class="alert alert-block alert-success">
			<h4><i class="icon-comments"></i> Feedback</h4>
			<p>Crediamo davvero nella collaborazione, infatti, come parte fondamentale del processo di sviluppo,
			   durante le riunioni di progettazione, ci fermiamo sempre un momento per leggere e 
			   prendere in considerazione il feedback ricevuto dagli utenti.</p>

			<p><strong>Se hai nuove idee, critiche o suggerimenti, scrivi all'indirizzo email:</strong></p>
			<a class="btn btn-large btn-success btn-block" href="mailto:feedback@gaia.cri.it?subject=Feedback+Gaia">
				<i class="icon-envelope-alt"></i>
				feedback@gaia.cri.it
			</a>
		</div>

		<div class="alert alert-block alert-info">
			<h4><i class="icon-bug"></i> White hat</h4>
			<p>Sei uno sviluppatore ed hai individuato del codice che credi possa essere migliorato?</p>
			<p>Per favore contattaci a <a href="mailto:info@gaia.cri.it?subject=White+hat+Segnalazione">info@gaia.cri.it</a> non appena possibile.</p>
		</div>


	</div>

</div>