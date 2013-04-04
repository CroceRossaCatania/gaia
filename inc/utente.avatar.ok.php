<?php

/*
 * ©2013 Croce Rossa Italiana
 */

ini_set('memory_limit', '512M');

if(isset($_GET['pre'])){

    $a = $_GET['id'];
    $v = new Volontario($a);
    $v = $v->avatar();

    try {
        $v->caricaFile($_FILES['avatar']);
    } catch (Exception $e) {
        redirect('presidente.utente.visualizza&aerr&id=' . $a);

    }

    redirect('presidente.utente.visualizza&aok&id=' . $a);
    
}else{
    
    $a = $me->avatar();

    try {
        $a->caricaFile($_FILES['avatar']);
    } catch (Exception $e) {
        redirect('utente.anagrafica&aerr');

    }

    redirect('utente.anagrafica&aok');

}
