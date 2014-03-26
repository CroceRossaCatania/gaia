<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

ini_set('memory_limit', '512M');

if(isset($_GET['pre'])){

    $a = $_GET['id'];
    $v = Volontario::id($a);
    $v = $v->avatar();

    if(!isset($_FILES['avatar'])) {
        redirect('presidente.utente.visualizza&aerr&id=' . $a);
    }

    try {
        $v->caricaFile($_FILES['avatar']);
    } catch (Exception $e) {
        redirect('presidente.utente.visualizza&aerr&id=' . $a);

    }

    redirect('presidente.utente.visualizza&aok&id=' . $a);
    
}else{
    
    $a = $me->avatar();

    if(!isset($_FILES['avatar'])) {
        redirect('utente.anagrafica&aerr');
    }

    try {
        $a->caricaFile($_FILES['avatar']);
    } catch (Exception $e) {
        redirect('utente.anagrafica&aerr');

    }

    redirect('utente.anagrafica&aok');

}
