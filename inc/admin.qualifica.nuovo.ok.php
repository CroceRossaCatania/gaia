<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();
controllaParametri(['inputNome'], 'admin.qualifica.nuovo&err');

if ( !isset($_POST['inputArea']) ) {
    die("Parametro tipo mancante, qualcosa e' andato storto.\n");
}

$x = Qualifiche::by('nome', $_POST['inputNome']);

if (!$x){
    $t = new Qualifiche();
    $t->area = intval(filter_input(INPUT_POST, 'inputArea'));
    $t->nome = maiuscolo(filter_input(INPUT_POST, 'inputNome'));
    $t->vecchiaNomenclatura = maiuscolo(filter_input(INPUT_POST, 'inputVecchioNome'));
    $t->attiva = intval(filter_input(INPUT_POST, 'inputAbilita'));
    redirect('admin.qualifica&new');
    
} else {
    redirect('admin.qualifica&dup');
}

?>
