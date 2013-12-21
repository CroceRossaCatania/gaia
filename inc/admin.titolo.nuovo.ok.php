<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
$parametri = array('inputNome', 'inputTipo');
controllaParametri($parametri, 'admin.titolo.nuovo&err');
$x = Titolo::by('nome', $_POST['inputNome']);
if (!$x){
$t = new Titolo();
$t->tipo = $_POST['inputTipo'];
$t->nome = maiuscolo( $_POST['inputNome'] );

redirect('admin.titoli&new');
}else{
    
redirect('admin.titoli&dup');
    
}
?>
