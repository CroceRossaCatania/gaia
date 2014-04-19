<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'presidente.utenti&err');
$t = $_GET['id'];
$t = Utente::id($t);

$f = Annunci::filtra([
  ['autore', $t]
  ]);
foreach($f as $_f){
    $_f->cancella();
}

$app = Appartenenza::filtra([
  ['volontario', $t]
  ]);
$a = $t->appartenenzaAttuale();

if($a) {
  $c = $a->comitato();
  $a = $a->id;
}


// roba legata ad appartenenza attuale
if($a) {
  $f = Attivita::filtra([
    ['referente', $t]
    ]);
  foreach($f as $_f){
      $_f->referente = $c->unPresidente();
  }

  $f = Autorizzazione::filtra([
    ['volontario', $t]
    ]);
  foreach($f as $_f){
      $_f->volontario = $c->unPresidente();
  }

  if($c) {
  $f = Gruppo::filtra([
    ['referente', $t]
    ]);
  foreach($f as $_f){
      $_f->referente = $c->unPresidente();
  }
}
}


// roba generica

$f = Avatar::filtra([
  ['utente', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Area::filtra([
  ['responsabile', $t]
  ]);
foreach($f as $_f){
    $_f->dimettiReferente();
}

$f = Commento::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Coturno::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Delegato::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Dimissione::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Documento::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Estensione::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = File::filtra([
  ['autore', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = AppartenenzaGruppo::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Partecipazione::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Privacy::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Reperibilita::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Riserva::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Sessione::filtra([
  ['utente', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = TitoloPersonale::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

$f = Trasferimento::filtra([
  ['volontario', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
}

// roba legata a tutte le appartenenza

foreach($app as $_app) {
  $f = Quota::filtra([
    ['appartenenza', $_app]
    ]);
  foreach ($f as $_f) {
      $_f->cancella();
  }
}

// cancella appartenenza
foreach($app as $_app){
    $_app->cancella();
}

// cancella anagrafica
$t->cancella();

redirect('presidente.utenti&ok');    

