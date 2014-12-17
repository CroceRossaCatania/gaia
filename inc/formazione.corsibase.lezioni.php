<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();
controllaParametri(['id']);

$admin = $me->admin();

$corso = CorsoBase::id($_GET['id']);
paginaCorsoBase($corso);
if (!$corso->modificabileDa($me)) {
	redirect("formazione.corsibase.scheda&id={$_GET['id']}");
}

?>
<?php if ( isset($_GET['date']) ) { ?>
<div class="alert alert-error">
    <i class="icon-warning-sign"></i> <strong>Data non valida</strong>.
    Hai inserito una data non valida. Non possono essere modificate date passate, per correggere
    contatta il supporto.
</div>
<?php } ?>
<?php if ( isset($_GET['assenze']) ) { ?>
<div class="alert alert-success">
    <i class="icon-save"></i> <strong>Dati salvati</strong>.
    Le assenze sono state correttamente registrate.
</div>
<?php } ?>
<a href="?p=formazione.corsibase.scheda&id=<?= $corso ?>" class="btn btn-small btn-primary">
	<i class="icon-reply"></i> Torna alla Scheda del Corso
</a>

<h3 class="allinea-centro"><?= $corso->nome(); ?></h3>
<h2 class="allinea-centro text-success"><i class="icon-calendar"></i> Gestione delle lezioni</h2>

<hr />

<form action="?p=formazione.corsibase.lezioni.ok&id=<?= $corso; ?>" method="POST">
<table class="table table-bordered table-striped">
	<thead>
		<th>Nome della lezione</th>
		<th>Inizio lezione</th>
		<th>Fine della lezione</th>
		<th>Assenti</th>
		<th>Elimina</th>
	</thead>
	<tbody>

	<?php foreach ( $corso->lezioni() as $lezione ) { ?>
		<tr class="modificabile">
			<td>
				<input type="hidden" name="lezioni[]" value="<?= $lezione->id; ?>" />
				<input type="text" name="nome_<?= $lezione->id; ?>" class=""
				 value="<?= $lezione->nome; ?>"
				 placeholder="Nome della lezione" required maxlength="64" />
			</td>
			<td>
				<input type="text" class="<?php if ($admin) echo "dtia"; elseif ($lezione->inizio()->getTimestamp() > time()) echo "dti"; ?>" name="inizio_<?= $lezione->id; ?>" required 
				 value="<?= $lezione->inizio()->format('d/m/Y H:i'); ?>"
				 placeholder="Inizio della lezione" 
				 <?php if (!$admin && $lezione->inizio()->getTimestamp() < time()) echo "readonly" ?>/>
			</td>
			<td>
				<input type="text" class="<?php if ($admin) echo "dtia"; elseif ($lezione->fine()->getTimestamp() > time()) echo "dti"; ?>" name="fine_<?= $lezione->id; ?>" required 
				 value="<?= $lezione->fine()->format('d/m/Y H:i'); ?>"
				 placeholder="Fine della lezione" 
				 <?php if (!$admin && $lezione->fine()->getTimestamp() < time()) echo "readonly" ?>/>
			</td>
			<td>
				<?php 
				$assenze = $lezione->assenze();
				if ($assenze) {
					$nAssenze = count($assenze);
					echo "<strong>{$nAssenze} registrate:</strong> ";
				} else {
					echo "<strong>Nessuna assenza registrata</strong>";
				}
				foreach ( $assenze as $assenza ) { ?>
					<?= $assenza->utente()->nomeCompleto() ?> 
					(<a title="Rimuovi assenza" href="?p=formazione.corsibase.lezioni.assenze.cancella&id=<?= $assenza->id; ?>" data-conferma="Sicuro di voler rimuovere questa assenza?"><i class="icon-remove"></i></a>),
					<?php
				} ?>
				<br /><a href="?p=formazione.corsibase.assenza&id=<?= $lezione->id ?>"
				   class="btn btn-mini btn-block">
				   <i class="icon-plus"></i> Registra assenze
			   	</a>
			</td>
			<td>
				<a href="?p=formazione.corsibase.lezioni.cancella&id=<?= $lezione->id; ?>" class="btn btn-block btn-danger"
					data-conferma="Rimuovendo la lezione, tutte le assenze registrate per la stessa andranno perse. Continuare?">
					<i class="icon-trash"></i>
					Rimuovi lezione
				</a>
			</td>
		</tr>
	<?php } ?>
	</form>

	<tr id="salva" class="info nascosto">
		<td>
			<h4><i class="icon-warning-sign"></i> Ricorda di salvare...</h4>
		</td>
		<td colspan="4">
			<button class="btn btn-large btn-primary btn-block">
				<i class="icon-save"></i> Salva modifiche
			</button>
		</td>
	</tr>

	<!-- Aggiunta di una nuova lezione -->
	<tr id="nuovo" class="success">
		<form action="?p=formazione.corsibase.lezioni.aggiungi&id=<?= $corso->id; ?>" method="POST">
		<td>
			<input type="text" name="nome" class="input-block"
			 placeholder="Nome della nuova lezione" required maxlength="64" />
		</td>
		<td>
			<input class="<?php if ($admin) echo "dtia"; else echo "dti"; ?>" name="inizio" required 
			 placeholder="Inizio della lezione" />
		</td>
		<td>
			<input class="<?php if ($admin) echo "dtia"; else echo "dti"; ?>" name="fine" required 
			 placeholder="Fine della lezione" />
		</td>
		<td colspan="2">
			<button type="submit" name="azione" value="aggiungi"
			 class="btn btn-success btn-block">
			 	<i class="icon-plus"></i>
			 	Aggiungi Lezione
		 	</button>
		</td>
		</form>
	</tr>
	
	</tbody>

</table>