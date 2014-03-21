<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();
paginaPresidenziale();

controllaParametri(['comitato', 'inputDataInizio'], 'formazione.corsibase&err');

$comitato = $_POST['comitato'];
$comitato = GeoPolitica::daOid($comitato);

proteggiClasse($comitato, $me);

$corsoBase                   = new CorsoBase();
$corsoBase->stato    		 = CORSO_S_DACOMPLETARE;
$corsoBase->organizzatore 	 = $comitato->oid();
$data 						 = DT::createFromFormat('d/m/Y', $_POST['inputDataInizio']);
$data 						 = $data;
$corsoBase->inizio    		 = $data->getTimestamp();
$corsoBase->anno 			 = $data->format('Y');
$corsoBase->aggiornamento	 = time();
$corsoBase->assegnaProgressivo();

redirect('formazione.corsibase.direttore&id=' . $corsoBase->id);

?>
