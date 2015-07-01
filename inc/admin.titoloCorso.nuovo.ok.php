<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(['inputNome'], 'admin.titoloCorso.nuovo&err');

$x = TitoloCorso::by('nome', $_POST['inputNome']);

print "x:<br/>";
print_r($_REQUEST);
print_r($x);
print "x:<br/>";

if (!$x){
    print "CORSO<br/>";
    $t = new TitoloCorso();
    print "fine<br/>";
    $t->nome = maiuscolo( $_POST['inputNome'] );
    //redirect('admin.titoliCorsi&new');
} else {
    //redirect('admin.titoliCorsi&dup');
}

?>
