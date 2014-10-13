<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(['id','inputAutoparco'], 'autoparco.veicoli&err');
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
  $inizio = @DateTime::createFromFormat('d/m/Y H:i', $_POST['inputData']);
  $inizio = @$inizio->getTimestamp();
  $collocazione = Collocazione::id($collocazioni[0]);
  $collocazione->fine = $inizio;
  $collocazione->pFine = $me;
  $collocazione->tFine = time();

  $collocazione = new Collocazione();

  $collocazione->veicolo = $veicolo;
  $collocazione->autoparco = $autoparco;
  $collocazione->inizio = $inizio;
  $collocazione->pConferma = $me;
  $collocazione->tConferma = time();

  redirect('autoparco.veicoli&new');
}

$collocazione = new Collocazione();

$inizio = @DateTime::createFromFormat('d/m/Y H:i', $_POST['inputData']);
$inizio = @$inizio->getTimestamp();
$collocazione->veicolo = $veicolo;
$collocazione->autoparco = $autoparco;
$collocazione->inizio = $inizio;
$collocazione->pConferma = $me;
$collocazione->tConferma = time();

redirect('autoparco.veicoli&new');
