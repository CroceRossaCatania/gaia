<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.donazioni&err');
$t = $_GET['id'];
$f = Donazione::id($t);
$tp = DonazionePersonale::filtra([['donazione', $f]]);
foreach ( $tp as $_tp ){
    $volontario = $_tp->volontario();
    $_tp->cancella();

	$m = DonazioneMerito::filtra([ ['volontario', $volontario->id], ['donazione', $tp->tipo] ]);
	if(count($m)){
		$p = DonazioneMerito::id($m[(count($m)-1)]->id);
		foreach($conf['merito'][$tp->tipo] as $value){
			if(count($volontario->donazioniTipo($tp->tipo)) <= $value)
				$p->cancella();
		}
	}
}
$f->cancella();

redirect('admin.donazioni&del');

?>
