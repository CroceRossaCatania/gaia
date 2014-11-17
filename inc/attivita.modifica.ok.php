<?php

paginaPrivata();
controllaParametri(array('id'), 'attivita.gestione&err');
$id = $_POST['id'];
$a = Attivita::id($id);
paginaAttivita($a);

$errori = [];

if ( isset($_POST['inputNome']) ) {
    $a->nome            = normalizzaTitolo($_POST['inputNome']);
    $a->descrizione     = $_POST['inputDescrizione'];
    $a->aggiornamento   = time();
    $a->visibilita      = $_POST['inputVisibilita'];
}

$turni = $a->turni();
foreach ( $turni as $t ) {
    if ( !isset($_POST["{$t->id}_nome"]) ) { continue; }
    $dinizio = DT::createFromFormat('d/m/Y H:i', $_POST["{$t->id}_inizio"]);
    $dfine = DT::createFromFormat('d/m/Y H:i', $_POST["{$t->id}_fine"]);

    if($dinizio >= $dfine){
        $errori[] = $_POST["{$t->id}_nome"];
        continue;
    }

    $t->nome            = normalizzaTitolo($_POST["{$t->id}_nome"]);
    $inizio             = $dinizio;
    $fine               = $dfine;
    $prenotazione       = DT::createFromFormat('d/m/Y H:i', $_POST["{$t->id}_prenotazione"]);
    $t->inizio          = $inizio->getTimestamp();
    $t->fine            = $fine->getTimestamp();
    $t->prenotazione    = $prenotazione->getTimestamp(); 
    $t->minimo          = (int) $_POST["{$t->id}_minimo"];
    $t->massimo         = (int) $_POST["{$t->id}_massimo"];   

}

switch ( $_POST['azione'] ) {
    case 'aggiungiTurno':
        $num = count($turni) + 1;
        $t = new Turno();
        $t->attivita    = $a->id;
        $t->inizio      = strtotime('+2 hours', $fine->getTimestamp());
        $t->fine        = strtotime('+4 hours', $fine->getTimestamp());
        $t->nome        = "Turno $num";
        $t->minimo      = 1;
        $t->massimo     = 4;
        $t->prenotazione= strtotime('-24 hours', $inizio->getTimestamp());
        redirect('attivita.turni&id=' . $a->id);
        break;
    
    case 'salva':
        // Salva.
        break;
    
    default:
        /* Cancella un turno ... */
        $t = Turno::id($_POST['azione']);
        $t->cancella();
        redirect('attivita.turni&id=' . $a->id);
        break;

    
}

if(!empty($errori)){
    $sessione->errori = json_encode($errori);    
}

redirect('attivita.scheda&id=' . $a->id);