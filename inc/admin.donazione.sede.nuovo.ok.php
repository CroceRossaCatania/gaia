<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
$x = DonazioneSede::by('nome', $_POST['inputNome']);
if (!$x){

    $t = new DonazioneSede();
    $t->tipo = $_POST['inputTipo'];
	$t->regione = $_POST['inputRegione'];
    $t->provincia = $_POST['inputProvincia'];
	$t->citta = $_POST['inputCitta'];
	$t->nome = $_POST['inputNome'];

    redirect('admin.donazioni.sedi&new');
}else{
    
    redirect('admin.donazioni.sedi&dup');
    
}

?>
