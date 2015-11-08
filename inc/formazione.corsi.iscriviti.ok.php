<?php
/*
 * ©2015 Croce Rossa Italiana
 */
//paginaAdmin();
paginaPrivata();

$id = intval($_POST['id']);

if (empty($id) || empty($me)) {
    redirect('formazione.corsi.iscriviti&id='.$id.'&err');
    die;
}

$c = null;
try {
    $c = Corso::id($id);
    
    if (empty($c) || empty($me)) {
        throw new Exception('Manomissione');
    }
    
    $c->inviaRichiestaIscrizione($me, $_POST);
    
} catch (Exception $e) {
    redirect('formazione.corsi.iscriviti&id='.$id.'&err');
    die;
}

redirect('formazione.corsi.iscriviti&id='.$id.'&ok');