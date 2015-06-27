<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('id'));

$d = $_GET['id'];
$d = DonazionePersonale::id($d);
$v = $d->volontario();

if ( !( $v == $me or $v->modificabileDa($me) ) ) {
    redirect('errore.permessi&cattivo&sangue');
}

$tipo = $d->donazione()->tipo;
$d->cancella();

$m = DonazioneMerito::filtra([ ['volontario', $v->id], ['donazione', $tipo] ]);
if(count($m)){
	$p = DonazioneMerito::id($m[(count($m)-1)]->id);
	foreach($conf['merito'][$tipo] as $value){
		if(count($v->donazioniTipo($tipo)) <= $value)
			$p->cancella();
	}
}

if(isset($_GET['pre'])){
    redirect('presidente.utente.visualizza&id='.$v->id);
}else{
    redirect('utente.donazioni&d=' . $tipo);    
}
