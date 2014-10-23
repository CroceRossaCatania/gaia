<?php

/*
* ©2014 Croce Rossa Italiana
*/

controllaParametri(['iscritto'], 'formazione.corsibase&err');
paginaAdmin();

$part = PartecipazioneBase::id($_POST['iscritto']);
$corso = $part->corsoBase();
$utente = $part->utente();

$utente->stato = PERSONA;
$part->cancella();

redirect("formazione.corsibase.scheda&id={$corso}&cancellatoAdmin");
