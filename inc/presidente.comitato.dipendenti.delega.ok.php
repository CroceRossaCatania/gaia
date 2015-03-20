<?php

/**
 * (c)2015 Croce Rossa Italiana
 */

$app = (int) $_POST['inputApplicazione'];
$oid = $_POST['inputComitato'];
$c = GeoPolitica::daOid($oid);

paginaApp(APP_PRESIDENTE, [$c]);

$cf = $_POST['inputCodiceFiscale'];

$redirect = "presidente.comitato.dipendenti.nuovo&applicazione={$app}&comitato={$oid}&cf={$cf}";

$u = Utente::by('codiceFiscale', $cf);

// Il CF inserito non esiste, OK!
if ( !$u )
	redirect($redirect);

// Il CF inserito esiste, ma non ho permessi... NO!
if ( !$u->modificabileDa($me) ) {
	?>

	<h3>Non posso selezionare il Dipendente.</h3>
	<p>Il codice fiscale inserito &egrave; corrispondente ad una persona gi&agrave; presente in Gaia come 
	   volontario, aspirante o socio ordinario <u>al di fuori del Comitato selezionato</u>.</p>
	<p>Se questo non &egrave; corretto, <a href="?p=utente.supporto">contatta la Squadra di Supporto</a>,
	   con i dettagli del caso e del Dipendente.</p>
	<p>Questo errore potrebbe essere dovuto ad una erronea registrazione del Dipendente come Volontario
	   od Aspirante all'interno di Gaia.</p>
	<p>Alternativamente, puoi <a href="?p=presidente.comitato&oid=<?= $oid; ?>">tornare alla gestione del Comitato</a>.

	<?php
	die();
}

// Il CF inserito esiste, ed ho i permessi...

// * Assumiamo che qualunque impostazione sia corretta
// * (es. volontario, aspirante, socio ordinario), quindi
// * permettiamo la nomina direttamente - redirect.

redirect("presidente.comitato.delegato&applicazione={$applicazione}&oid={$oid}&persona={$u->id}");
