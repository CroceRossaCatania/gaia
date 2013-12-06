<?php

paginaPrivata();

if ( $me->stato != ASPIRANTE )
	redirect('utente.me');

// Se non ho ancora registrato il mio essere aspirante
if ( !($a = Aspirante::daVolontario($me)) )
	redirect('aspirante.registra');
$a->raggio = $a->trovaRaggioMinimo();
?>

<h2>Ciao, <?php echo $me->nome; ?>.</h2>
<p>Ci sono <?php echo $a->numComitati(); ?> nelle tue vicinanze, per ulteriori informazioni <a href="?p=public.comitati.mappa">consulta la mappa</a>.</p>


<?php //yeah, funziona. var_dump($a->comitati(), $a->raggio);