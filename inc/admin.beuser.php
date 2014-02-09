<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$id = $_GET['id'];
$sessione->utente = $id;
$sessione->ambito = null;
redirect('utente.me');

?>
