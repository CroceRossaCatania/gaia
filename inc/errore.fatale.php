<?php
 
/*
 * ©2014 Croce Rossa Italiana
 */

// Impedisce l'accesso diretto
if ( !isset($_GET['errore']) )
	redirect('home');

$errore = htmlentities($_GET['errore']);

// Imposta errore 500 come stato HTTP
header('HTTP/1.1 500 Internal Server Error');

?>

<div class="span8 offset2">

	<h2 class="text-error">
		<i class="icon-exclamation-sign"></i>
		Oops... qualcosa &egrave; andato storto!
	</h2>

	<hr />
	<h3 class="text-warning">
		<i class="icon-frown"></i>
		Non siamo riusciti ad elaborare la pagina. 
	</h3>
	<p>
		&Egrave; occorso un errore grave durante l'elaborazione della tua richiesta.
		Siamo spiacenti per l'inconveniente.<br />
		Gaia ha interrotto l'esecuzione del programma per evitare la corruzione dei dati sui quali stavi lavorando.
	</p>

	<p>&nbsp;</p>

	<h3 class="text-warning">
		<i class="icon-cogs"></i>
		Gli sviluppatori sono stati avvisati del problema.
	</h3>
	<p>
		L'errore &egrave; stato registrato dal Sistema di Gestione degli Errori &mdash; con tutti i dettagli del caso.<br />
		Gaia ha inoltre avvisato automaticamente gli sviluppatori, che indagheranno sul problema.
	</p>

	<p>&nbsp;</p>

	<h3 class="text-success">
		<i class="icon-question-sign"></i>
		Cosa fare ora?
	</h3>
	<p>
		Ti preghiamo di tornare indietro e di non provare ad eseguire nuovamente l'azione prima di qualche ora.<br />
		Se hai notato un comportamento ricorrente per questo errore, perfavore segnalacelo cliccando sotto.
	</p>
	<p>&nbsp;</p>


	<span class="btn-group row-fluid">
		<a class="btn btn-large btn-primary span4" href="javascript:history.go(-1);">
			<i class="icon-reply"></i>
			Torna indietro
		</a>
		<a class="btn btn-large span4" href="/">
			<i class="icon-home"></i>
			Home page
		</a>
		<a class="btn btn-large span4" href="?p=utente.supporto&errore=<?php echo $errore; ?>">
			<i class="icon-warning-sign"></i>
			Segnala l'errore
		</a>
	</span>

	<p>&nbsp;</p>

	<hr />

</div>