<?php

/*
 * ©2014 Croce Rossa Italiana
 */


/*
 * Normalizzazione dei dati
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);
controllaParametri(array('t'), 'presidente.utenti&errGen');

$id = $_GET['t'];
$p = Utente::id($id);
proteggiDatiSensibili($p);

$admin = $me->admin();

$dnascita       = DT::createFromFormat('d/m/Y', $_POST['inputDataNascita']);
$dnascita       = $dnascita->getTimestamp();
$prnascita      = maiuscolo($_POST['inputProvinciaNascita']);
$conascita      = normalizzaNome($_POST['inputComuneNascita']);
$coresidenza    = normalizzaNome($_POST['inputComuneResidenza']);
$caresidenza    = normalizzaNome($_POST['inputCAPResidenza']);
$prresidenza    = maiuscolo($_POST['inputProvinciaResidenza']);
$indirizzo      = normalizzaNome($_POST['inputIndirizzo']);
$civico         = maiuscolo($_POST['inputCivico']);
$cell           = normalizzaNome($_POST['inputCellulare']);
$cells          = normalizzaNome(@$_POST['inputCellulareServizio']);


/*
 * Registrazione vera e propria...
 */

$p->dataNascita         = $dnascita;
$p->provinciaNascita    = $prnascita;
$p->comuneNascita       = $conascita;
$p->comuneResidenza     = $coresidenza;
$p->CAPResidenza        = $caresidenza;
$p->provinciaResidenza  = $prresidenza;
$p->indirizzo           = $indirizzo;
$p->civico              = $civico;
$p->cellulare           = $cell;
$p->cellulareServizio   = $cells;
$p->timestamp           = time();

/* 
 * Non si può far parte di IV e CM contemporaneamente
 */

if ( !$admin && (!$_POST['inputIV'] && $_POST['inputCM']) || ($_POST['inputIV'] && !$_POST['inputCM']) ) {
    $x=0;
    if ( $_POST['inputIV'] && $p->sesso == DONNA ){
        $p->iv = $_POST['inputIV'];
        $x++;
    }

    if( $_POST['inputCM'] && $p->sesso == UOMO){
        $p->cm = $_POST['inputCM'];
        $x++;
    }

    if ( $x == 0 ){
        redirect('presidente.utente.visualizza&sesso&id='.$id);
    }

}elseif( $admin ){
    $p->iv = $_POST['inputIV'];
    $p->cm = $_POST['inputCM'];

}

if ($admin) {
    $nome               = normalizzaNome($_POST['inputNome']);
    $cognome            = normalizzaNome($_POST['inputCognome']);
    $sesso              = $_POST['inputSesso'];
    $codiceFiscale      = maiuscolo($_POST['inputCodiceFiscale']);
    $email              = minuscolo($_POST['inputEmail']);
    $stato              = $_POST['inputStato'];

    /*
     * Controlla se sto scrivendo una email in possesso ad altro utente
     */
    if($email != $p->email && Utente::by('email', $email)){
        redirect('presidente.utente.visualizza&email&id='.$_GET['t']);
    }

    if ( $p->codiceFiscale != $codiceFiscale && Utente::by('codiceFiscale', $codiceFiscale) )
            redirect('presidente.utente.visualizza&cf&id='.$_GET['t']);

    $p->nome            = $nome;
    $p->cognome         = $cognome;
    $p->sesso           = ($sesso) ? UOMO : DONNA;
    $p->codiceFiscale   = $codiceFiscale;
    $p->email           = $email;
    $p->stato           = $stato;
}

redirect('presidente.utente.visualizza&ok&id='.$id);
