<?php

paginaPrivata();

// Redirect ad applicazione
if ( $sessione->app_redirect ) {
	header("Location: {$sessione->app_redirect}");
	exit(0);
}

?>

<h2>
	<i class="icon-spinner icon-spin"></i>
	Attendere...
</h2>

<p>&Egrave; in corso l'accesso all'applicazione.</p>

