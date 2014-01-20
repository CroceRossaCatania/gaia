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
    ['stato', ISCR_RICHIESTA]
    ]);

if($p) {
    redirect("formazione.corsibase.scheda&id={$corso->id}&gia");
}


$p = new PartecipazioneBase();
$p->volontario = $me;
$p->corsoBase = $corso;
$p->stato = ISCR_RICHIESTA;
$p->timestamp = time();


redirect("formazione.corsibase.scheda&id={$corso->id}&iscritto");

?>
