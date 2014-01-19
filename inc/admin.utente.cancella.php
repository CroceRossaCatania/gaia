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

$f = Appartenenza::filtra([
  ['volontario', $t]
  ]);
$a = $t->ultimaAppartenenza();
$c = $a->comitato();
foreach($f as $_f){
    $_f->cancella();
}

$f = Area::filtra([
  ['responsabile', $t]
  ]);
foreach($f as $_f){
    $_f->dimettiReferente();
}

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

$f = Avatar::filtra([
  ['utente', $t]
  ]);
foreach ($f as $_f) {
    $_f->cancella();
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

$f = Gruppo::filtra([
  ['referente', $t]
  ]);
foreach($f as $_f){
    $_f->referente = $c->unPresidente();
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

$f = Quota::filtra([
  ['appartenenza', $a]
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

$t = Persona::id($t);
$t->cancella();

if($me->id==$t){
    $sessione->logout();
}else{
    redirect('presidente.utenti&ok');    
}

?>
