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
$corsoBase->stato    		 = CORSO_S_ATTIVO;
$corsoBase->organizzatore 	 = $comitato->oid();
$data 						 = DT::createFromFormat('d/m/Y', $_POST['inputDataInizio']);
$data 						 = $data->getTimestamp();
$corsoBase->inizio    		 = $data;
$corsoBase->assegnaProgressivo();

redirect('formazione.corsibase.direttore&id=' . $corsoBase->id);

?>
