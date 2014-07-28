<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(array('id','inputAutoparco'), 'autoparco.veicoli&err');
$veicolo = $_GET['id'];
$autoparco = $_POST['inputAutoparco'];

$collocazioni = Collocazione::filtra([['veicolo', $veicolo],['autoparco', $autoparco]]);

foreach ( $collocazioni as $collocazione ){
  if ( $collocazione -> attuale() ){
    redirect('autoparco.veicoli&gia');
  }
}

$collocazioni = Collocazione::filtra([['veicolo', $veicolo],['fine', null]]);

if ( $collocazioni ){
  $collocazione = Collocazione::id($collocazioni[0]);
  $collocazione->fine = time();
  $collocazione->pFine = $me;
  $collocazione->tFine = time();

  $collocazione = new Collocazione();

  $collocazione->veicolo = $veicolo;
  $collocazione->autoparco = $autoparco;
  $collocazione->inizio = time();
  $collocazione->pConferma = $me;
  $collocazione->tConferma = time();

  redirect('autoparco.veicoli&new');
}

$collocazione = new Collocazione();

$collocazione->veicolo = $veicolo;
$collocazione->autoparco = $autoparco;
$collocazione->inizio = time();
$collocazione->pConferma = $me;
$collocazione->tConferma = time();

redirect('autoparco.veicoli&new');
