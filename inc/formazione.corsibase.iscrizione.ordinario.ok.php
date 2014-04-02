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



$p = new PartecipazioneBase();
$p->volontario = $u;
$p->corsoBase = $corso;
$p->stato = ISCR_RICHIESTA;
$p->timestamp = time();
$p->concedi();

$u->stato = ASPIRANTE;

redirect('presidente.soci.ordinari&iscritto');

