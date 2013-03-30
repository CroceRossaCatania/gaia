<?php

$a = new Attivita($_POST['id']);
$a->luogo = $_POST['formattato'];
$a->localizzaStringa($_POST['formattato']);
redirect('attivita.scheda&id=' . $a->id);