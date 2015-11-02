<?php

/*
* ©2014 Croce Rossa Italiana
*/

caricaSelettore();
controllaParametri(['id']);

$lezione = GiornataCorso::id($_GET['id']);
$corso = $lezione->corso();

if (!$corso->modificabile()) {
	redirect("formazione.corsi.riepilogo&id={$corso->id}");
}

$lezione->cancella();

redirect("formazione.corsi.lezioni&id={$corso->id}");
