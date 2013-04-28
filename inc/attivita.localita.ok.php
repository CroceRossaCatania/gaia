<?php

$a = new Attivita($_POST['id']);

$a->stato = ATT_STATO_OK;

$a->luogo = $_POST['formattato'];
$a->localizzaStringa($_POST['formattato']);
redirect('attivita.modifica&id=' . $a->id);