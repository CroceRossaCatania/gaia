<?php

$id = $_POST['id'];
$a = new Attivita($id);

$a->nome            = normalizzaNome($_POST['inputNome']);
$a->descrizione     = $_POST['inputDescrizione'];
$a->aggiornamento   = time();

$a->visibilita      = $_POST['inputVisibilita'];

// $a->stato           = $_POST['inputStato'];

$turni = $a->turni();
foreach ( $turni as $t ) {
    $t->nome    = normalizzaNome($_POST["{$t->id}_nome"]);
    $inizio     = DT::createFromFormat('d/m/Y H:i', $_POST["{$t->id}_inizio"]);
    $fine       = DT::createFromFormat('d/m/Y H:i', $_POST["{$t->id}_fine"]);
    $t->inizio  = $inizio->getTimestamp();
    $t->fine    = $fine->getTimestamp();
    $t->minimo  = (int) $_POST["{$t->id}_minimo"];
    $t->massimo = (int) $_POST["{$t->id}_massimo"];  
}

switch ( $_POST['azione'] ) {
    case 'aggiungiTurno':
        $num = count($turni) + 1;
        $t = new Turno();
        $t->attivita    = $a->id;
        $t->inizio      = $fine->getTimestamp();
        $t->fine        = strtotime('+2 hours', $fine->getTimestamp());
        $t->nome        = "Turno $num";
        $t->minimo      = 1;
        $t->massimo     = 4;
        redirect('attivita.modifica&id=' . $a->id);
        break;
    
    case 'salva':
        // Salva.
        break;
    
    default:
        /* Cancella un turno ... */
        $t = new Turno($_POST['azione']);
        $t->cancella();
        redirect('attivita.modifica&id=' . $a->id);
        break;

    
}

redirect('attivita.scheda&id=' . $a->id);
