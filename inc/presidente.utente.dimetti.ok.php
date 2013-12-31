<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

controllaParametri(array('id','motivo','info'), 'presidente.utenti&errGen');

$v = Volontario::id($_GET['id']);
$attuale = $v->appartenenzaAttuale();
$comitato = $attuale->comitato();

/* Avviso il volontario */
$m = new Email('dimissionevolontario', 'Dimissione Volontario: ' . $v->nomeCompleto());
$m->da      = $me;
$m->a       = $v;
$m->_NOME   = $v->nome;
$m->_MOTIVO = $conf['dimissioni'][$_POST['motivo']];
$m->_INFO   = $_POST['info'];
$m->invia();

/* Creo la dimissione */                
$d = new Dimissione();
$d->volontario      = $v->id;
$d->appartenenza    = $attuale;
$d->comitato        = $comitato;
$d->motivo = $_POST['motivo'];
$d->info = $_POST['info'];
$d->tConferma = time();
$d->pConferma = $me;

/* Evitiamo di lasciare compiti a chi non è più in CRI */
$f = Area::filtra([
  ['responsabile', $v]
  ]);
foreach($f as $_f){
    $_f->dimettiReferente();
}

$f = Attivita::filtra([
  ['referente', $v]
  ]);
foreach($f as $_f){
    $_f->referente = $comitato->unPresidente();
}

$f = Autorizzazione::filtra([
  ['volontario', $v]
  ]);
foreach($f as $_f){
    $_f->volontario = $comitato->unPresidente();
}

$f = Gruppo::filtra([
  ['referente', $v]
  ]);
foreach($f as $_f){
    $_f->referente = $comitato->unPresidente();
}

$f = AppartenenzaGruppo::filtra([
  ['volontario', $v]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Reperibilita::filtra([
  ['volontario', $v]
  ]);
foreach ($f as $_f) {
    $_f->fine = time();
}

$f = TitoloPersonale::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

/* da rivedere da qui in poi */

$f = Delegato::filtra([
  ['volontario', $v]
  ]);
foreach ($f as $_f) {
    $_f->fine = time();
}

$f = Partecipazione::filtra([
  ['volontario', $v]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}


$f = Estensione::filtra([
  ['volontario', $v]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Riserva::filtra([
  ['volontario', $v]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Trasferimento::filtra([
  ['volontario', $v]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

/* Chiudo l'appartenenza e declasso a persona */
$attuale->fine = time();
$attuale->stato = MEMBRO_DIMESSO;
$v->stato = PERSONA;
$v->admin=null;
               
redirect('presidente.utenti&dim');   
?>