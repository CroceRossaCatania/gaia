<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('oid'), 'admin.comitati&err');
$t = $_GET['oid'];
$t = GeoPolitica::daOid($t);

if($t->figli()){
	redirect('admin.comitati&figli');
}

$app = Appartenenza::filtra([['comitato', $t]]);

foreach ( $app as $appa ){

	if (Quota::filtra(['appartenenza', $appa]))
		redirect('admin.comitati&quota');

	if ( $appa->stato == MEMBRO_VOLONTARIO )
		redirect('admin.comitati&evol');

	$riserve = Riserva::filtra([['appartenenza', $appa]]);
	foreach( $riserve as $riserva ){
		$riserva->cancella();
	}

	$estensioni = Estensione::filtra([['appartenenza', $appa]]);
	foreach( $estensioni as $estensione ){
		$estensione->cancella();
	}

	$trasferimenti = Trasferimento::filtra([['appartenenza', $appa]]);
	foreach( $trasferimenti as $trasferimento ){
		$trasferimento->cancella();
	}
		
	$appa->cancella();

}

/* Cancello aree e responsabili */
$aree = Area::filtra([
  ['comitato', $t]
]);
foreach($aree as $area){
    $area->cancella();
}

/* Cancello le attività */
$attivita = Attivita::filtra([
  ['comitato', $t]
]);
foreach($attivita as $att){
	$turni = Turno::filtra([['attivita', $att]]);
	foreach ( $turni as $turno ){
		$partecipazioni = Partecipazione::filtra([['turno', $turno]]);
		foreach( $partecipazioni as $partecipazione ){
			$autorizzazioni = Autorizzazione::filtra([['partecipazione', $partecipazione]]);
			foreach( $autorizzazioni as $autorizzazione ){
				$autorizzazione->cancella();
			}
			$partecipazione->cancella();
		}
		$coturni = Coturno::filtra([['turno', $turno]]);
		foreach( $coturni as $coturno ){
			$coturno->cancella();
		}
		$turno->cancella();
	}
	$mipiaci = Like::filtra([['oggetto', $att->oid()]]);
	foreach( $mipiaci as $mipiace ){
		$mipiace->cancella();
	}
    $att->cancella();
}

/* Cancello autoparchi e veicoli ad esso associati li passo al nazionale */
$autoparchi = Autoparco::filtra([
  ['comitato', $t->oid()]
]);
foreach($autoparchi as $autoparco){
    $collocazioni = Collocazione::filtra([['autoparco', $autoparco]]);

    foreach ( $collocazioni as $collocazione ){
    	$collocazione->cancella()
    }

    $auoparco->cancella();
}

/* Cancello i corsi base */
$corsibase = CorsoBase::filtra([
  ['comitato', $t->oid()]
]);
foreach($corsibase as $corsobase){
    $lezioni = Lezione::filtra([['corso', $corsobase]]);
    foreach( $lezioni as $lezione ){
    	$assenze = AssenzaLezione::filtra([['lezione', $lezione]]);
    	foreach( $assenze as $assenza ){
    		$assenza->cancella();
    	}
    }
    $partecipazioni = PartecipazioneBase::filtra([['corsoBase', $corsobase]]);
    foreach($partecipazioni as $partecipazione){
    	$partecipazione->cancella();
    }
    $corsobase->cancella();
}

/* Cancello i delegati */
$delegati = Delegato::filtra([
	['comitato', $t->oid()]
]);
foreach( $delegati as $delegato ){
	$delegato->cancella();
}

/* Cancello le dimissioni */
$dimissioni = Dimissione::filtra([
	['comitato', $t]
]);
foreach( $dimissioni as $dimissione ){
	try{
		$appartenenza = $dimissione->appartenenza();
		$appartenenza->cancella();
	}catch(Exception $e){

	}
	$dimissione->cancella();
}

/* Cancello le dimissioni */
$estensioni = Estensione::filtra([
	['cProvenienza', $t]
]);
foreach( $estensioni as $stensione ){
	try{
		$appartenenza = $estensione->appartenenza();
		$appartenenza->cancella();
	}catch(Exception $e){

	}
	$estensione->cancella();
}

/* Cancello i gruppi personali */
$appgruppi = AppartenenzaGruppo::filtra([
	['comitato', $t]
]);
foreach( $appgruppi as $appgruppo ){
	$appgruppo->cancella();
}

/* Cancello i gruppi */
$gruppi = Gruppo::filtra([
	['comitato', $t->oid()]
]);
foreach( $gruppi as $gruppo ){
	$gruppo->cancella();
}

/* Cancello reperibilità */
$reperibilita = Reperibilita::filtra([
  ['comitato', $t]
]);
foreach($reperibilita as $reperibile){
    $reperibile->cancella();
}

/* Assegno veicoli a nazionale */
$veicoli = Veicolo::filtra([
  ['comitato', $t->oid()]
]);
foreach($veicoli as $veicolo){
    $veicolo->comitato = "Nazionale:1";
}

/* Ora posso cancellare il comitato */
$t->cancella();
redirect('admin.comitati&del');
