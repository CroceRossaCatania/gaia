<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$parametri = array('id', 'inputCommento');

if ( isset($_GET['h']) ){
    $parametri = array_merge( $parametri, $_GET['h']);
}

controllaParametri($parametri);

$a = $_GET['id'];
$a = Attivita::id($a);

$h = $_GET['h'];

if ( empty($_POST['inputCommento']) ) {
    redirect('attivita.scheda&id=' . $a->id);
}

$c = new Commento();
$c->attivita = $a;
$c->commento = $_POST['inputCommento']; 

if($h != 0){
    $c->upCommento = $h;
}else{
    $c->upCommento = 0;
}
$c->volontario = $me;
$c->tCommenta = time();

if ( isset($_POST['annuncia'] ) ) {
    
    foreach ( $a->volontariFuturi() as $v ) {
        
        $m = new Email('aggiornamentoattivita', "Aggiornamento attività {$a->nome}");
        $m->_NOME       =   $v->nomeCompleto();
        $m->_AUTORE     =   $me->nomeCompleto();
        $m->_ATTIVITA   =   $a->nome;
        $m->_TESTO      =   $c->commento;
        $m->_ID         =   $a->id;
        $m->a           =   $v;
        $m->da          =   $me;
        $m->invia();
        
    }
    
}

redirect('attivita.scheda&id=' . $a->id);
