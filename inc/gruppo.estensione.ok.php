<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

controllaParametri(array('id'), 'gruppi.dash&err');

$g = $_POST['id'];
$g = Gruppo::id($g);

proteggiClasse($g, $me);

$g->estensione=$_POST['inputEstensione'];

redirect('gruppi.dash&estok');
?>
