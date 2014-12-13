<?php

/*
 * (c)2014 Croce Rossa Italiana
 */

paginaAdmin();

caricaSelettore();

$r = [];

?>


<table class="table table-condensed">
	<tbody>
		<?php
		foreach ( explode("\n", $_POST['volontari']) as $codice ) { 
			$codice = maiuscolo($codice);
			if ( !$codice ) { continue; }
			$v = Utente::daCodicePubblico($codice);
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

