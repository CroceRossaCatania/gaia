<?php

/*
* ©2014 Croce Rossa Italiana
*/

caricaSelettore();
controllaParametri(['id']);

$assenza = AssenzaLezione::id($_GET['id']);
$corso = $assenza->corso();
if (!$corso->modificabileDa($me)) {
	redirect("formazione.corsibase.scheda&id={$corso->id}");
}

$assenza->cancella();
redirect("formazione.corsibase.lezioni&id={$corso->id}");
