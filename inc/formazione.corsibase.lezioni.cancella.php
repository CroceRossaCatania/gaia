<?php

/*
* ©2014 Croce Rossa Italiana
*/

caricaSelettore();
controllaParametri(['id']);

$lezione = Lezione::id($_GET['id']);
$corso = $lezione->corso();
if (!$corso->modificabileDa($me)) {
	redirect("formazione.corsibase.scheda&id={$corso->id}");
}

$lezione->cancella();
redirect("formazione.corsibase.lezioni&id={$corso->id}");
