<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();
controllaParametri(['id', 'formattato'], 'formazione.corsibase&err');
$corso = CorsoBase::id($_POST['id']);

paginaCorsoBase($corso);

$corso->luogo = $_POST['formattato'];
$corso->localizzaStringa($_POST['formattato']);
redirect('formazione.corsibase.modifica&id=' . $corso->id);

?>
