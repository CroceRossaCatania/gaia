<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(['inputNome'], 'admin.qualifica.nuovo&err');

if ( !isset($_POST['inputTipo']) ) {
    die("Parametro tipo mancante, qualcosa e' andato storto.\n");
}

$x = Qualifica::by('nome', $_POST['inputNome']);

if (!$x){
    $t = new Qualifica();
    $t->tipo = (int) $_POST['inputTipo'];
    $t->nome = maiuscolo( $_POST['inputNome'] );

    redirect('admin.qualifica&new');
    
} else {
    
    redirect('admin.qualifica&dup');
    
}

?>
