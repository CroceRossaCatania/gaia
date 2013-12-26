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
if(Appartenenza::filtra([['comitato', $t]])){
	redirect('admin.comitati&evol');
}

/* Cancello i delegati */
$delegati = Delegato::filtra([
	['comitato', $t]
]);
foreach( $delegati as $delegato ){
	$delegato->cancella();
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
    $att->cancella();
}

/* Ora posso cancellare il comitato */
$t->cancella();
redirect('admin.comitati&del');

?>
