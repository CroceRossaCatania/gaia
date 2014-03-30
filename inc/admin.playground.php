<?php

paginaAdmin();

?>
<h2>Playground</h2>
<pre>
<?php


$c = new Barcode;
$c->genera($me->codicePubblico());
$c->anteprima();

	$f = new Excel;
	$f->intestazione(['a', 'b']);
	$f->aggiungiRiga(['1', '2']);
	$f->genera('Prova file.xls');

	$m = new Email('mailTestolibero', 'Prova di invio');
	$m->a = [
		Utente::by('email', 'alfio.emanuele.f@gmail.com'),
		Utente::by('email', 'alfio.emanuele.f@gmail.com'),
		Utente::by('email', 'alfio.emanuele.f@gmail.com'),
		Utente::by('email', 'alfio.emanuele.f@gmail.com'),
	];
	$m->da = Utente::by('email', 'alfio.emanuele.f@gmail.com');
	$m->_TESTO = 'Prova di testo <b>html</b>';
	$m->allega($f);
	$m->allega($f);
	$m->accoda();



	foreach ( MEmail::inCoda() as $y ) {
		$y = MEmail::object($y);
		echo "Invio email {$y}...\n";
		$y->invia();

	}










?>
</pre>

