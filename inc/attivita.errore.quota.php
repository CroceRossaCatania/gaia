<?php

paginaPrivata();

$a = $_GET['id'];
$a = Attivita::id($a);

?>

<div class="row-fluid">
	<div class="span8 offset2">

		<h3><i class="icon-warning-sign"></i> Quota non registrata</h3>

		<p><strong>Siamo spiacenti, non possiamo inoltrare la richiesta di partecipazione a questa attivit&agrave;.</strong></p>

		<p>Il Presidente del Comitato organizzatore ha scelto di limitare la possibilit&agrave; partecipazione alle attivit&agrave; dello 
		stesso Comitato ai Volontari aventi una Quota registrata nell'anno. 
		Questo viene generalmente imposto per motivi assicurativi.</p>

		<p>
			<strong>Cosa puoi fare?</strong>

			<ul>
				<li><a href="javascript:history.go(-1);">Torna alla pagina dell'attivit&agrave;</a>;</li>
				<li>Se hai pagato la quota e questa non &egrave; stata registrata, rivolgiti al tuo Ufficio Soci o al tuo Presidente;</li>
				<li>Per qualsiasi altro dubbio, <a href="?p=utente.mail.nuova&id=<?= $a->comitato()->primoPresidente(); ?>">contatta il Presidente del Comitato organizzatore</a>.</li>
			</ul>

		</p>

	</div>
</div>