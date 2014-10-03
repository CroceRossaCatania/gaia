<?php

/*
* ©2014 Croce Rossa Italiana
*/

caricaSelettore();
controllaParametri(['id']);
 
$corso = CorsoBase::id($_GET['id']);
if (!$corso->modificabileDa($me)) {
	redirect("formazione.corsibase.scheda&id={$_GET['id']}");
}

$lezioni = $_POST['lezioni'];
foreach ( $lezioni as $lezione ) {
	$lezione = Lezione::id($lezione);
	$lezione->nome = normalizzaNome($_POST["nome_{$lezione}"]);
	$inizio    			= DT::createFromFormat('d/m/Y H:i', $_POST["inizio_{$lezione}"]);
	$fine       		= DT::createFromFormat('d/m/Y H:i', $_POST["fine_{$lezione}"]);
	$lezione->inizio	= $inizio->getTimestamp();
	$lezione->fine 		= $fine->getTimestamp();

	if ( isset($_POST["assenti_{$lezione}"]) ) {
		foreach ( $_POST["assenti_{$lezione}"] as $_r ) {
			$_r = Utente::id($_r);
			if ( $lezione->assente($_r) ) {
				continue;
			}
			$a = new AssenzaLezione;
			$a->utente 	= $_r;
			$a->lezione = $lezione;
			$a->pConferma = $me;
			$a->tConferma = time();
		}
	}
}

redirect("formazione.corsibase.lezioni&id={$_GET['id']}");
