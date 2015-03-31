<?php

/*
 * ©2014 Croce Rossa Italiana
 */


/*
 * Normalizzazione dei dati
 */

paginaSupporto();
controllaParametri(array('t'), 'presidente.utenti&errGen');

$id = $_GET['t'];
$p = Utente::id($id);
//proteggiDatiSensibili($p);

$log = "Utente: ".$me->nome." ".$me->cognome." id: ".$me->id." ha modifica l'utente con id = ".$p->id." in data ".time();

$supporto = $me->supporto();

if (empty($dnascita) && !empty($p->$dnascita)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}

if (empty($prnascita) && !empty($p->$dnascita)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}
if (empty($conascita) && !empty($p->$dnascita)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}
if (empty($coresidenza) && !empty($p->$coresidenza)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}
if (empty($prresidenza) && !empty($p->$prresidenza)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}
if (empty($indirizzo) && !empty($p->$indirizzo)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}
if (empty($civico) && !empty($p->$civico)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}
if (empty($cell) && !empty($p->$cell)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}
if (empty($cells) && !empty($p->$cells)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}

if (empty($nome) && !empty($p->$nome)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}
if (empty($cognome) && !empty($p->$cognome)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}
if (empty($sesso) && !empty($p->$sesso)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}
if (empty($codiceFiscale) && !empty($p->$codiceFiscale)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}
if (empty($email) && !empty($p->$email)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}
if (empty($stato) && !empty($p->$stato)){
    redirect('supporto.utente.visualizza&campi&id='.$id);
}


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

if($p->dataNascita != $dnascita){
    $log.=" modifica della data di nascita da: ".$p->dataNascita." a: ".$dnascita;
}
$p->dataNascita         = $dnascita;

if($p->provinciaNascita != $prnascita){
    $log.=" modifica della provincia di nascita da: ".$p->provinciaNascita." a: ".$prnascita;
}
$p->provinciaNascita    = $prnascita;

if($p->comuneNascita != $conascita){
    $log.=" modifica del comune di nascita da: ".$p->comuneNascita." a: ".$conascita;
}
$p->comuneNascita       = $conascita;

if($p->comuneResidenza != $coresidenza){
    $log.=" modifica del comune di residenza da: ".$p->comuneResidenza." a: ".$coresidenza;
}
$p->comuneResidenza     = $coresidenza;

if($p->CAPResidenza != $caresidenza){
    $log.=" modifica del CAP di residenza da: ".$p->CAPResidenza." a: ".$caresidenza;
}
$p->CAPResidenza        = $caresidenza;

if($p->provinciaResidenza != $prresidenza){
    $log.=" modifica della provincia di residenza da: ".$p->provinciaResidenza." a: ".$prresidenza;
}
$p->provinciaResidenza  = $prresidenza;

if($p->indirizzo != $indirizzo){
    $log.=" modifica dell'indirizzo' da: ".$p->indirizzo." a: ".$indirizzo;
}
$p->indirizzo           = $indirizzo;

if($p->civico != $civico){
    $log.=" modifica del civico da: ".$p->civico." a: ".$civico;
}
$p->civico              = $civico;

if($p->cellulare != $cell){
    $log.=" modifica del cellulare da: ".$p->cellulare." a: ".$cell;
}
$p->cellulare           = $cell;

if($p->cellulareServizio != $cells){
    $log.=" modifica del cellulare di servizio da: ".$p->cellulareServizio." a: ".$cells;
}
$p->cellulareServizio   = $cells;

$p->timestamp           = time();

/* 
 * Non si può far parte di IV e CM contemporaneamente
 */

$x=0;
if ( $_POST['inputIV'] && $p->sesso == DONNA ){
    $p->iv = $_POST['inputIV'];
    $x++;
    $log.= " il campo iv passa da ".$p->iv." a ".$_POST['inputIV'];
}

if( $_POST['inputCM'] && $p->sesso == UOMO){
    $p->cm = $_POST['inputCM'];
    $x++;
    $log.= " il campo cm passa da ".$p->cm." a ".$_POST['inputCM'];
}

if( !$_POST['inputCM'] && !$_POST['inputIV']){
    $p->iv = false;
    $p->cm = false;
    $x++;
    $log.= " le checkbox per i campi iv e cm non sono state settate";
}

if ( $x == 0 ){
    redirect('supporto.utente.visualizza&sesso&id='.$id);
}

if( $admin ){
    $p->iv = $_POST['inputIV'];
    $p->cm = $_POST['inputCM'];

}

if ($supporto) {
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
        redirect('supporto.utente.visualizza&email&id='.$_GET['t']);
    }

    if ( $p->codiceFiscale != $codiceFiscale && Utente::by('codiceFiscale', $codiceFiscale) )
            redirect('supporto.utente.visualizza&cf&id='.$_GET['t']);

    if($p->nome != $nome){
        $log.=" modifica del nome da: ".$p->nome." a: ".$nome;
    }
    $p->nome            = $nome;
    
    if($p->cognome != $cognome){
        $log.=" modifica del cognome da: ".$p->cognome." a: ".$cognome;
    }
    $p->cognome         = $cognome;

    $a = ($sesso) ? UOMO : DONNA;
    if($p->sesso != $a){
        
        $log.=" modifica del sesso da: ".$p->sesso." a: ".$a;
    }
    $p->sesso           = ($sesso) ? UOMO : DONNA;

    if($p->codiceFiscale != $codiceFiscale){
        $log.=" modifica del codice fiscale da: ".$p->codiceFiscale." a: ".$codiceFiscale;
    }    
    $p->codiceFiscale   = $codiceFiscale;
    
    if($p->email != $email){
        $log.=" modifica dell'email da: ".$p->email." a: ".$email;
    }
    $p->email           = $email;
    
    if($p->stato != $stato){
        $log.=" modifica dello stato da: ".$p->stato." a: ".$stato;
    }
    $p->stato           = $stato;
}

//echo $log;

$q = $db->prepare("INSERT INTO logSupporto (valore) VALUES (:log)");
$q->bindParam(":log", $log);
$q->execute();
redirect('supporto.utente.visualizza&ok&id='.$id);
