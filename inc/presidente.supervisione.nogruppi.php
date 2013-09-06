<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$gruppi = $me->gruppiDiCompetenza();
$g = [];
foreach ($gruppi as $gruppo){
        $g = array_merge($g, $gruppo->membri());
}
$g = array_unique($g);
$comitati= $me->comitatiDiCompetenza();
$volontari = [];
foreach($comitati as $comitato){
	$volontari = array_merge($volontari, $comitato->membriAttuali(MEMBRO_VOLONTARIO));
}
$volontari = array_unique($volontari);
$mancanti = array_diff( $volontari, $g);
foreach ($mancanti as $mancante ){
	$v = $mancante->volontario();
	echo $v->nomeCompleto(),"<br/>";
}
