<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(['inputNome'], 'admin.certificato.nuovo&err');

$x = Certificato::by('nome', $_POST['inputNome']);
if (!$x){
    $t = new Certificato();
    $t->nome = maiuscolo( $_POST['inputNome'] );
    redirect('admin.certificati&new');
} else {
    redirect('admin.certificati&dup');
}

?>
