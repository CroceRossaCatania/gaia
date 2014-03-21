<?php

controllaParametri(['id', 'formattato'], 'attivita.gestione&err');
$a = Attivita::id($_POST['id']);

paginaAttivita($a);

$a->stato = ATT_STATO_OK;

$a->luogo = $_POST['formattato'];
$a->localizzaStringa($_POST['formattato']);
redirect('attivita.modifica&id=' . $a->id);

?>
