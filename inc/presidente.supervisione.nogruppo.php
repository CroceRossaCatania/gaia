<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

?>
<script type="text/javascript"><?php require './js/presidente.utenti.js'; ?></script>
<br/>
<div class="row-fluid">
	<div class="span5">
		<h2>
			<i class="icon-group muted"></i>
			Volontari non iscritti a gruppi di lavoro
		</h2>
	</div>
	<div class="span3">
		<div class="btn-group btn-group-vertical span12">
			<a href="?p=presidente.supervisione" class="btn btn-block">
				<i class="icon-reply"></i>
				Torna indietro
			</a>
		</div>
	</div>
	<div class="span4 allinea-destra">
		<div class="input-prepend">
			<span class="add-on"><i class="icon-search"></i></span>
			<input autofocus required id="cercaUtente" placeholder="Cerca Volontario..." type="text">
		</div>
	</div>
</div>
<hr />
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-bordered" id="tabellaUtenti">
			<thead>
				<th>Nome</th>
				<th>Cognome</th>
				<th>Data di nascita</th>
				<th>Comitato</th>
				<th>Azione</th>
			</thead>
			<?php
			$gruppi = $me->gruppiDiCompetenza();
			$g = [];
			$comitati= $me->comitatiApp([APP_PRESIDENTE]);
			$volontari = [];
			foreach($comitati as $comitato){
				$volontari = array_merge($volontari, $comitato->membriAttuali(MEMBRO_VOLONTARIO));
				foreach($volontari as $_v) {
					if($_v->gruppiAttuali()) {
						$g[] = $_v;
					}
				}
			}
			$volontari = array_unique($volontari);
			$g = array_unique($g);
			$mancanti = array_diff( $volontari, $g);
			foreach ($mancanti as $mancante ){ ?>
		 		<tr>
					<td><?php echo $mancante->nome; ?></td>
					<td><?php echo $mancante->cognome; ?></td>
					<td><?php echo $mancante->codiceFiscale; ?></td>
					<td><?php echo $mancante->unComitato()->nomeCompleto(); ?></td>
					<td>
						<div class="btn-group">
							<a class="btn btn-small" href="?p=presidente.utente.visualizza&id=<?php echo $mancante->id; ?>" target="_new" title="Dettagli">
							<i class="icon-eye-open"></i> Dettagli
						</a>
							<a class="btn btn-info btn-small" href="?p=presidente.supervisione.utente.gruppi&id=<?php echo $mancante->id; ?>" target="_new" title="Storico turni">
							<i class="icon-time"></i> Storico Gruppi
						</a>
							<a class="btn btn-small btn-success" href="?p=utente.mail.nuova&id=<?php echo $mancante->id; ?>" title="Invia Mail">
							<i class="icon-envelope"></i>
						</a>
						</div>
					</td>
				</tr>
	<?php	} ?>
	 	</table>
	</div>
</div>
