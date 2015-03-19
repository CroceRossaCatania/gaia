<?php

/*
 * ©2012 Croce Rossa Italiana
 */
if ($me->delegazioneAttuale()->comitato()->permettiTrasferimentiUS()){
	paginaApp([APP_SOCI, APP_PRESIDENTE]);
}else{
	paginaApp([APP_PRESIDENTE]);
}


controllaParametri(array('id'), 'presidente.trasferimento&err');

$t     = $_GET['id'];
$t = Trasferimento::id($t);

if (isset($_GET['si'])) {
	$t->trasferisci();    
	redirect('presidente.trasferimento&ok');  
} elseif (isset($_GET['no'])) {
	$t->nega($_POST['motivo']);
	redirect('presidente.trasferimento&no');   
}

redirect('presidente.trasferimento&err');
?>