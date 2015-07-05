<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(['inputNome'], 'admin.titoloCorso.nuovo&err');

$x = TitoloCorso::by('nome', $_POST['inputNome']);
if (!$x){
    $t = new TitoloCorso();
    $t->nome = maiuscolo( $_POST['inputNome'] );
    redirect('admin.titoliCorsi&new');
} else {
    redirect('admin.titoliCorsi&dup');
}

?>
