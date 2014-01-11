<?php

paginaPrivata();
controllaParametri(['id', 'formattato'], 'formazione.corsibase&err');
$corso = CorsoBase::id($_POST['id']);

paginaCorsoBase($corso);

$corso->stato = CORSO_S_ATTIVO;

$corso->luogo = $_POST['formattato'];
$corso->localizzaStringa($_POST['formattato']);
redirect('formazione.corsibase.modifica&id=' . $corso->id);

?>
