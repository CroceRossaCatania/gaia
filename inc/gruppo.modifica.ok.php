<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$g = $_POST['id'];
$g = Gruppo::id($g);
$nome = $_POST['inputNome'];
if(!$nome){
	redirect('gruppi.dash&nome');
}
$g->nome   =   $nome;

redirect('gruppi.dash&ok');
?>
