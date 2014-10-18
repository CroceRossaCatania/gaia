<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();
paginaPresidenziale();

controllaParametri(['comitato', 'inputDataInizio'], 'formazione.corsibase&err');

$comitato = $_POST['comitato'];
$comitato = GeoPolitica::daOid($comitato);

proteggiClasse($comitato, $me);
$data = DT::daFormato($_POST['inputDataInizio'], 'd/m/Y H:i');
if (!$data) {
	redirect('formazione.corsibase&err');
}


$corsoBase                   = new CorsoBase();
$corsoBase->stato            = CORSO_S_DACOMPLETARE;
$corsoBase->organizzatore    = $comitato->oid();
$corsoBase->inizio           = $data->getTimestamp();
$corsoBase->tEsame           = (int) $corsoBase->inizio + MESE;
$corsoBase->anno             = $data->format('Y');
$corsoBase->aggiornamento    = time();
$corsoBase->assegnaProgressivo();


redirect('formazione.corsibase.direttore&id=' . $corsoBase->id);


