<?php

/*
 * ©2013 Croce Rossa Italiana
 */

controllaParametri(array('id'), 'gruppi.dash&err');

$g = $_POST['id'];
$g = Gruppo::id($g);

proteggiClasse($g, $me);

$nome = $_POST['inputNome'];
if(!$nome){
	redirect('gruppi.dash&nome');
}
$g->nome   =   $nome;

redirect('gruppi.dash&ok');
?>
