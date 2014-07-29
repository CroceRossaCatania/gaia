<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

controllaParametri(array('id'), 'gruppi.dash&err');

$g   = $_POST['id'];
$g   = Gruppo::id($g);
$est = $g->attivita()->comitato()->_estensione();

proteggiClasse($g, $me);

if ( $est == EST_REGIONALE ) {
    $g->estensione  =   EST_GRP_REGIONALE;    
} elseif ( $est == EST_PROVINCIALE ) {
    $g->estensione  =   EST_GRP_PROVINCIALE;
} else {
	$g->estensione  =   $_POST['inputEstensione'];
}

redirect('gruppi.dash&estok');
?>
