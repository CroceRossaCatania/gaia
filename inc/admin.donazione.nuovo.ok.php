<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
$x = Donazione::by('nome', $_POST['inputNome']);
if (!$x){
    $t = new Donazione();
    $t->tipo = $_POST['inputTipo'];
    $t->nome = maiuscolo( $_POST['inputNome'] );

    redirect('admin.donazioni&new');
}else{
    
    redirect('admin.donazioni&dup');
    
}

?>
