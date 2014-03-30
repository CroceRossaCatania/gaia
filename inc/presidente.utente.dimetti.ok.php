<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

controllaParametri(array('id','motivo','info'), 'presidente.utenti&errGen');

$v = Volontario::id($_GET['id']);

proteggiDatiSensibili($v, [APP_SOCI , APP_PRESIDENTE]);
if (!$v->modificabileDa($me)) {
  redirect('presidente.utenti&nonpuoi');
}

$attuale = $v->appartenenzaAttuale();
$comitato = $attuale->comitato();
$motivo = $conf['dimissioni'][$_POST['motivo']];

/* Avviso il volontario */
$m = new Email('dimissionevolontario', 'Dimissione Volontario: ' . $v->nomeCompleto());
$m->da      = $me;
$m->a       = $v;
$m->_NOME   = $v->nome;
$m->_MOTIVO = $motivo;
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

$f = Estensione::filtra([
  ['volontario', $v]
  ]);
foreach ($f as $_f) {
  if($_f->stato == EST_OK || $_f->stato == EST_AUTO){
    $_f->termina();
  }elseif($_f->stato == EST_INCORSO){
    $_f->nega($motivo);
  }
}

$f = Riserva::filtra([
  ['volontario', $v]
  ]);
foreach ($f as $_f) {
  if($_f->stato == RISERVA_OK || $_f->stato == RISERVA_AUTO){
    $_f->termina();
  }elseif($_f->stato == RISERVA_INCORSO){
    $_f->nega($motivo);
  }
}

$f = Trasferimento::filtra([
  ['volontario', $v]
  ]);
foreach ($f as $_f) {
  if($_f->stato == TRASF_INCORSO){
    $_f->nega($motivo);
  }
}

$p = Partecipazione::filtra([
  ['volontario', $v]
]);
foreach ($p as $_p) {
  if ( $_p->turno()->futuro() && $_p->turno()->attivita()->comitato() == $c->id) {
    $_p->cancella();
  }
}

$f = Delegato::filtra([
  ['volontario', $v]
  ]);
foreach ($f as $_f) {
  $_f->fine = $fine;
}

/* Chiudo l'appartenenza e declasso a persona */
$ora = time();
$comitato = $attuale->comitato;
$attuale->fine = $ora;
$attuale->stato = MEMBRO_DIMESSO;
$v->stato = PERSONA;
$v->admin=null;

/* Se dimissioni volontarie e l'ha chiesto lo lascio ordinario */

if($d->motivo == DIM_VOLONTARIE && isset($_POST['ordinario'])) {
  $a = new Appartenenza();
  $a->volontario  = $v;
  $a->inizio      = $ora;
  $a->comitato    = $comitato;
  $a->fine        = PROSSIMA_SCADENZA;
  $a->timestamp   = time();
  $a->stato       = MEMBRO_ORDINARIO;
  $a->conferma    = $me;
}
               
redirect('presidente.utenti&dim');   
?>