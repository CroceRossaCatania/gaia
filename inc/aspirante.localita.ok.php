<?php

paginaPrivata();

controllaParametri(['formattato'], 'aspirante.home&err');

if ($me->stato != ASPIRANTE
    && !(Aspirante::daVolontario($me)) ){
    
    redirect('aspirante.registra');
}

$a = Aspirante::daVolontario($me);
$a->luogo = $_POST['formattato'];
$a->localizzaStringa($a->luogo);
$a->raggio = $a->trovaRaggioMinimo();

redirect('aspirante.home');

?>
