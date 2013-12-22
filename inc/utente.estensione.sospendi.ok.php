<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

controllaParametri(array('elimina'), 'utente.riserva');


$id = $_POST['elimina'];

$e = Estensione::id($id);
$e->annulla();

redirect('utente.estensione&ann');
?>
