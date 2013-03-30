<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
$x = Comitato::by('nome', $_POST['inputNome']);
if (!$x){
$c = new Comitato();
$c->nome = normalizzaNome( $_POST['inputNome'] );

redirect('admin.comitati&new');
}else{
    
redirect('admin.comitati&dup');
    
}
?>
