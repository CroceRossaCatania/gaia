<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
$x = DonazioneSedi::by('nome', $_POST['inputNome']);
if (!$x){

    $t = new DonazioneSedi();
    $t->tipo = $_POST['inputTipo'];
    $t->nome = $_POST['inputNome'];
    $t->provincia = $_POST['inputProvincia'];
    $t->regione = $_POST['inputRegione'];

    redirect('admin.donazioni.sedi&new');
}else{
    
    redirect('admin.donazioni.sedi&dup');
    
}

?>
