<?php

/*
* ©2014 Croce Rossa Italiana
*/

caricaSelettore();
controllaParametri(['id', 'nome', 'inizio', 'fine']);
 
$corso = CorsoBase::id($_GET['id']);
if (!$corso->modificabileDa($me)) {
	redirect("formazione.corsibase.scheda&id={$_GET['id']}");
}

$l = new Lezione;
$l->corso 	= (int) $_GET['id'];
$l->nome 	= normalizzaNome($_POST['nome']);
$inizio     = DT::createFromFormat('d/m/Y H:i', $_POST["inizio"]);
$fine       = DT::createFromFormat('d/m/Y H:i', $_POST["fine"]);
$l->inizio  = $inizio->getTimestamp();
$l->fine 	= $fine->getTimestamp();

redirect("formazione.corsibase.lezioni&id={$_GET['id']}");
