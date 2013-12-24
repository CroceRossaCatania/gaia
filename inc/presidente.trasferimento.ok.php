<?php

/*
 * ©2012 Croce Rossa Italiana
 */

paginaPresidenziale();

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