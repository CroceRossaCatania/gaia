<?php

/*
 * (c)2014 Croce Rossa Italiana
 */

paginaAdmin();

caricaSelettore();


?>

<h3>Jump &mdash; Step 0</h3>
<h4>Selezione dei volontari</h4>

<form action="?p=admin.jump.step1" method="POST">

	Inserisci un codice fiscale per riga<br />
    <textarea name="volontari" rows="10" cols="400"></textarea><br />

    <button type="submit" class="btn btn-primary">
    	Cerca i volontari
	</button>

</form>