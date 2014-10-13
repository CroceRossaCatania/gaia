<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaApp([APP_AUTOPARCO , APP_PRESIDENTE]);

controllaParametri(['id'], 'autoparco.veicoli&err');
$veicolo = $_GET['id'];
$veicolo = new Veicolo ($veicolo);

proteggiVeicoli($veicolo, [APP_AUTOPARCO, APP_PRESIDENTE]);

if ( $veicolo->fermoTecnico() ){
  $manutenzioni = Manutenzione::filtra([['veicolo', $veicolo]],'tIntervento DESC');
  $fermotecnico = Fermotecnico::id($veicolo->fermoTecnico());

  if ( $manutenzioni[0]->tIntervento > $fermotecnico->inizio ){
    $fermotecnico->fine  = time();
    $fermotecnico->pFine = $me;
    $fermotecnico->tFine = time();

    $veicolo->fermotecnico = null;

    redirect('autoparco.veicoli&outFT');
  }else{
    redirect('autoparco.veicolo.manutenzione.nuovo&id=' . $veicolo->id);
  }
	

}else{
  	$fermotecnico = new Fermotecnico();
  	$fermotecnico->veicolo = $veicolo;
  	$fermotecnico->inizio  = time();
  	$fermotecnico->pInizio = $me;
  	$fermotecnico->tInizio = time();
  	$fermotecnico->motivo  = $_POST['inputMotivo'];

  	$veicolo->fermotecnico = $fermotecnico->id;

  	redirect('autoparco.veicoli&regFT');  

}