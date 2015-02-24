<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('oid'), 'admin.comitati&err');
$oid = $_GET['oid'];
$t = GeoPolitica::daOid($oid);

if($t->figli()){
	redirect('admin.comitati&figli');
}

if( $t->_estensione() != EST_UNITA ) {
	$t->cancella();
	redirect('admin.comitati&del');
}

$app = Appartenenza::filtra([['comitato', $t]]);

foreach ( $app as $appa ){

	if (Quota::filtra([['appartenenza', $appa]]))
		redirect('admin.comitati&quota');

	if ( $appa->stato == MEMBRO_VOLONTARIO )
		redirect('admin.comitati&evol');

}

$t->cancella();

redirect('admin.comitati&del');
