<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(array('id'), 'admin.qualifica&err');
$id = filter_input(INPUT_GET, "id");

$t = Qualifiche::id($id);
$t->area = intval(filter_input(INPUT_POST, 'inputArea'));
$t->nome = maiuscolo(filter_input(INPUT_POST, 'inputNome'));
$t->vecchiaNomenclatura = maiuscolo(filter_input(INPUT_POST, 'inputVecchioNome'));
$t->attiva = intval(filter_input(INPUT_POST, 'inputAbilita'));


print_r($t);

redirect('admin.qualifica&mod');

?>
