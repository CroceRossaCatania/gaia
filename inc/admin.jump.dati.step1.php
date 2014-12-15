<?php

/*
 * (c)2014 Croce Rossa Italiana
 */

paginaAdmin();

caricaSelettore();

$r = [];

?>


<h4>Tutti quanti</h4>

<table class="table table-condensed">
	<tbody>
		<?php
		foreach ( explode("\n", $_POST['volontari']) as $codice ) { 
			$codice = maiuscolo($codice);
			if ( !$codice ) { continue; }
			$v = Utente::daCodicePubblico($codice);
			$r[$v->id] = ( array_key_exists($v->id, $r) ? $r[$v->id] : 0 ) + 1;
			?>
			<tr>
				<td style="font-family: monospace;"><?= $codice; ?></td>
				<td><?= $v->cognome; ?></td>
				<td><?= $v->nome; ?></td>
				<td style="font-family: monospace;"><?= $v->codiceFiscale; ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<hr />

<h4>Duplicati</h4>

<table class="table table-condensed">
	<tbody>
	<?php foreach ( $r as $id => $num ) { 
		if ( $num == 1 ) { continue; }
		$v = Utente::id($id);
		?>
			<tr>
				<td style="font-family: monospace; font-weight: bold;"><?= $num; ?></td>
				<td style="font-family: monospace;"><?= $codice; ?></td>
				<td><?= $v->cognome; ?></td>
				<td><?= $v->nome; ?></td>
				<td style="font-family: monospace;"><?= $v->codiceFiscale; ?></td>
			</tr>
		<?php
	}
	?>
	</tbody>
</table>	