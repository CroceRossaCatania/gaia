<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(['inputNome'], 'admin.titolo.nuovo&err');

if ( !isset($_POST['inputTipo']) ) {
	die("Parametro tipo mancante, qualcosa e' andato storto.\n");
}

$x = Titolo::by('nome', $_POST['inputNome']);

if (!$x){
    $t = new Titolo();
    $t->tipo = (int) $_POST['inputTipo'];
    $t->nome = maiuscolo( $_POST['inputNome'] );

    redirect('admin.titoli&new');
    
} else {
    
    redirect('admin.titoli&dup');
    
}

?>
