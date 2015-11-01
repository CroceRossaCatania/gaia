<?php

/*
* ©2014 Croce Rossa Italiana
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
    ['stato', ISCR_RICHIESTA]
    ]);

if($p) {
    redirect("formazione.corsibase.scheda&id={$corso->id}&gia");
}


$part = new PartecipazioneBase();
$part->volontario = $me;
$part->corsoBase = $corso;
$part->stato = ISCR_RICHIESTA;
$part->timestamp = time();


redirect("formazione.corsibase.scheda&id={$corso->id}&iscritto");

?>
