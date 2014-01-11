<?php

/*
* ©2013 Croce Rossa Italiana
*/

paginaPrivata();
caricaSelettore();

controllaParametri(array('id'));

$corso = CorsoBase::id($_GET['id']);

if ($me instanceof Anonimo) {
   redirect('utente.me');
}

if ($me->stato != ASPIRANTE) {
    redirect('utente.me');
}

if (!$corso->accettaIscrizioni()) {
    redirect("formazione.corsibase.scheda&id={$corso->id}");
}

$p = PartecipazioneBase::filtra([
    ['volontario', $me],
    ['corsoBase', $corso],
    ]);

foreach($p as $_p) {
	if ($_p->attiva()) {
		$_p->stato = ISCR_ANNULLATA;
		redirect("formazione.corsibase.scheda&id={$corso->id}&cancellato");
	}
}

redirect("formazione.corsibase.scheda&id={$corso->id}&err");

?>
