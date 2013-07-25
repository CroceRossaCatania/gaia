<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

$g = $_POST['id'];
$g = new Gruppo($g);
$nome = $_POST['inputNome'];
$g->nome   =   $nome;

redirect('gruppi.dash&ok');
?>
