<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

controllaParametri(array('id'), 'gruppi.dash&err');

$g = $_POST['id'];
$g = Gruppo::id($g);
$g->estensione=$_POST['inputEstensione'];

redirect('gruppi.dash&estok');
?>
