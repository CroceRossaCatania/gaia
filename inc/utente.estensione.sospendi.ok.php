<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

if(!isset($_POST['elimina']))
{
    redirect('utente.riserva');
}

$id = $_POST['elimina'];

$e = Estensione::id($id);
$e->annulla();

redirect('utente.estensione&ann');
?>
