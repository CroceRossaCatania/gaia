<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();

if (isset($_POST['inputDestinatario'])) {
    $id = $_POST['inputDestinatario'];
    $v = utente::id($id);
}

$corso = CorsoBase::id($_GET['id']);
paginaCorsoBase($corso);

$oggetto= $_POST['inputOggetto']; 
$testo = $_POST['inputTesto'];

if(isset($_GET['iscrizioni'])) {

    $part = $corso->partecipazioni(ISCR_CONFERMATA);

    foreach ( $part as $p ) { 
        $iscritto = $p->utente();
        $m = new Email('mailTestolibero', ''.$oggetto);
        $m->da = $me; 
        $m->a = $iscritto;
        $m->_TESTO = $testo;
        $m->accoda(); 
    }

} elseif(isset($_GET['preiscrizioni']))  {

    $part = $corso->partecipazioni(ISCR_RICHIESTA);

    foreach ( $part as $p ) { 
        $iscritto = $p->utente();
        $m = new Email('mailTestolibero', ''.$oggetto);
        $m->da = $me; 
        $m->a = $iscritto;
        $m->_TESTO = $testo;
        $m->accoda(); 
    }  

}  

redirect('utente.me&ok');
?>