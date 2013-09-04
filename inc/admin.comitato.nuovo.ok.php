<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

$c = $_GET['id'];

if (isset($_GET['com'])){
        
        $nome = normalizzaNome( $_POST['inputNome'] );
        $gia = Comitato::filtra([['nome', $nome],['locale', $c]]);
        if ( $gia ){
            redirect('admin.comitati&dup');
        }
        $t = new Comitato();
        $t->nome = $nome;
        $t->locale = $c;
        $t->principale = (int) $_POST['inputPrincipale'];
        redirect('admin.comitati&new');
    
}elseif (isset($_GET['loc'])){
    
    $nome = normalizzaNome( $_POST['inputNome'] );
        $gia = Locale::filtra([['nome', $nome],['provinciale', $c]]);
        if ( $gia ){
            redirect('admin.comitati&dup');
        }
    $t = new Locale();
    $t->nome = $nome;
    $t->provinciale = $c;
    redirect('admin.comitati&new');
    
}elseif (isset($_GET['pro'])){
    
    $nome = normalizzaNome( $_POST['inputNome'] );
        $gia = Provinciale::filtra([['nome', $nome],['regionale', $c]]);
        if ( $gia ){
            redirect('admin.comitati&dup');
        }
    $t = new Provinciale();
    $t->nome = $nome;
    $t->regionale = $c;
    redirect('admin.comitati&new');
    
}elseif (isset($_GET['regi'])){
    
    $nome = normalizzaNome( $_POST['inputNome'] );
        $gia = Regionale::filtra([['nome', $nome],['nazionale', $c]]);
        if ( $gia ){
            redirect('admin.comitati&dup');
        }
    $t = new Regionale();
    $t->nome = normalizzaNome( $_POST['inputNome'] );
    $t->nazionale = $c;
    redirect('admin.comitati&new');
    
}elseif (isset($_GET['naz'])){
    
    $nome = normalizzaNome( $_POST['inputNome'] );
        $gia = Nazionale::filtra([['nome', $nome]]);
        if ( $gia ){
            redirect('admin.comitati&dup');
        }
    $t = new Nazionale();
    $t->nome = $nome;
    redirect('admin.comitati&new');
    
}
