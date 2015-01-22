<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();
controllaParametri(['id']);

$admin = $me->admin();

$i = 0;

$corso = CorsoBase::id($_GET['corso']);
paginaCorsoBase($corso);
if (!$corso->modificabileDa($me)) {
	redirect("formazione.corsibase.scheda&id={$_GET['corso']}");
}
$utente = Utente::id($_GET['id']);

?>

<h2 class="allinea-centro text-success"><i class="icon-calendar"></i> Elenco assenze</h2>
<h3 class="allinea-centro"><?= $utente->nomeCompleto(); ?></h3>

<hr />
<div class="row-fluid">
	<table class="table table-striped table-bordered">

		<thead>
			<th>Nome della lezione</th>
			<th>Inizio lezione</th>
			<th>Fine della lezione</th>
		</thead>

		<?php foreach ( $corso->lezioni() as $lezione ) { 
			$assenza = AssenzaLezione::filtra([['utente', $utente],['lezione', $lezione]]); 
			if ( !$assenza ){
				continue;
			}
			$assenza = $assenza[0]; 
			$i++; ?>
			<tr>
				<td><?= $lezione->nome; ?></td>
				<td><?= date('d/m/Y H:i', $lezione->inizio); ?></td>
				<td><?= date('d/m/Y H:i', $lezione->fine); ?></td>
			</tr>
		<?php } ?>
	</table>
<h4 class="allinea-sinistra">Totale assenze: <?= $i; ?></h4>
</div>