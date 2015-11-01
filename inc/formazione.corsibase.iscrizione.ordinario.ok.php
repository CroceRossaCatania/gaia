<?php

/*
* ©2014 Croce Rossa Italiana
*/

controllaParametri(['id', 'corso'], 'presidente.soci.ordinari&err');
paginaPrivata();

$u = Utente::id($_GET['id']);
$corso = $_GET['corso'];

proteggiDatiSensibili($u, [APP_SOCI, APP_PRESIDENTE]);
paginaApp([APP_SOCI , APP_PRESIDENTE]);
if($u->partecipazioniBase(ISCR_CONFERMATA)) {
    redirect('presidente.soci.ordinari&gia');
}

if(!CorsoBase::id($corso)) {
    redirect('presidente.soci.ordinari&err');
}



$part = new PartecipazioneBase();
$part->volontario = $u;
$part->corsoBase = $corso;
$part->stato = ISCR_RICHIESTA;
$part->timestamp = time();
$part->concedi();

$u->stato = ASPIRANTE;

redirect('presidente.soci.ordinari&iscritto');

