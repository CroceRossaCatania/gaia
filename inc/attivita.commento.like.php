<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

$parametri = array('id');
controllaParametri($parametri);

$commento = $_GET['id'];
$commento = Commento::id($commento);

$gia = Like::filtra([['volontario', $me],['commento', $commento]]);

if ( $gia ){
    $gia[0]->cancella();
}

$like = new Like();
$like->commento   = $commento;
$like->volontario = $me;
$like->timestamp  = time();

if (isset($_GET['piace'])){

    $like->stato = PIACE;

}else{

    $like->stato = NON_PIACE;

}

redirect('attivita.scheda&id=' . $commento->attivita()->id);
