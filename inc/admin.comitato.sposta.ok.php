<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$t = GeoPolitica::daOid($_GET['oid']);
$c = GeoPolitica::daOid($_POST['inputComitato']);
$estensione = $t->_estensione();
$motivo = "Cambio Presidente dell'unità territoriale";

$delegati = Delegato::filtra([
	['comitato', $t],
	['applicazione', APP_OBIETTIVO]
]);
foreach ($delegati as $delegato){
	$delegato->fine = time();
}
	
if($estensione==EST_UNITA){
	/* Estensioni dal comitato */
	$est = Estensione::filtra([
	  ['cProvenienza', $t],
	  ['stato', EST_INCORSO]
	]);
	foreach( $est as $este ){
		$este->nega($motivo);
	}

	/* Estensioni verso il comitato */
	$appest = Appartenenza::filtra([
	  ['comitato', $t],
	  ['stato', MEMBRO_EST_PENDENTE]
	]);
	foreach( $appest as $apest ){
		$apest->estensione()->nega($motivo);
	}

	/* Trasferimenti dal comitato */
	$trasf = Trasferimento::filtra([
	  ['cProvenienza', $t],
	  ['stato', TRASF_INCORSO]
	]);
	foreach( $trasf as $trasfe ){
		$trasfe->nega($motivo);
	}

	/* Trasferimenti verso il comitato */
	$apptrasf = Appartenenza::filtra([
	  ['comitato', $t],
	  ['stato', MEMBRO_TRASF_IN_CORSO]
	]);
	foreach( $apptrasf as $aptrasf ){
		$aptrasf->trasferimento()->nega($motivo);
	}

	$riserve = Riserva::filtra([
	  ['comitato', $t],
	  ['stato', RISERVA_INCORSO]
	]);
	foreach( $riserve as $riserva ){
		$riserva->nega($motivo);
	}
	
	$t->principale = 0;
	$t->locale = $c;
}elseif($estensione==EST_LOCALE){
	$t->provinciale = $c;
}elseif($estensione==EST_PROVINCIALE){
	$t->regionale = $c;
}
GeoPolitica::rigeneraAlbero();
redirect('admin.comitati&spostato');
