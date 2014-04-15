<?php  

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

$parametri = array('v', 'turno');
controllaParametri($parametri);

$v = $_GET['v'];
$turno = Turno::id($_GET['turno']);

$comitato = $turno->Attivita()->comitato();

if(isset($_POST['inputPotere'])){
    
    $potere = $_POST['inputPotere'];
        
}else{
    
    $delegazioni = $me->delegazioni();
    $potere = $delegazioni[0]->applicazione;
}

$partecipazione = Partecipazione::filtra([['volontario', $v],['turno', $turno]]);
$gia = Delegato::filtra([['volontario', $v],['partecipazione', $partecipazione[0]]]);

if(!$gia){
    
    $d = new Delegato();
    $d->estensione      = $comitato->_estensione();
    $d->comitato        = $comitato->oid();
    $d->applicazione    = $potere;
    $d->dominio         = null;
    $d->inizio          = $turno->inizio;
    $d->fine            = $turno->fine;
    $d->pConferma       = $me->id;
    $d->tConferma       = time();
    $d->volontario      = $v;
    $d->partecipazione = $partecipazione[0];

    redirect('attivita.scheda&pot&id=' . $turno->attivita()->id);

}else{
    
    redirect('attivita.scheda&not&id=' . $turno->attivita()->id);
    
}

?>
