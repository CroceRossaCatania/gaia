<?php
paginaAttivita();
$t = Turno::id($_POST['turno']);

$titolo = Titolo::by('nome', $_POST['titolo']);

if (!$titolo) {
    redirect("attivita.richiesta.turni&id={$t}");
    
}
$r = RichiestaTurno::id($_GET['id']);
$r->turno = $t;

$e = new ElementoRichiesta();
$e->titolo = $titolo;
$e->richiesta = $r;

redirect("attivita.richiesta.turni&id={$t}");