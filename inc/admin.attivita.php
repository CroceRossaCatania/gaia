<?php


/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

set_time_limit(0);
?>
<h3><i class="icon-wrench muted"></i> Riparazione attività senza referente</h3>
<code>
<?php
$attivita = Attivita::elenco();
$eseguiti=0;
foreach( $attivita as $a ){
	try {
			$referente = $a->referente();
    	} catch (Exception $e) {
    		echo "Attività rotta:", $a->nome, "<br/>";
			$referente = $a->referente;
			$comitato = $a->comitato();
			$presidente = $comitato->unPresidente();
			$autorizzazioni = Autorizzazione::filtra(['volontario', $referente]);
			foreach ( $autorizzazioni as $autorizzazione ){
				$m = new Autorizzazione($autorizzazione);
				$m->volontario = $presidente;
			}
			$att = new Attivita($a);
			$att->referente = $presidente;
			$eseguiti++;
			continue;
    	}
}
?>
Eseguite <strong><?= $eseguiti; ?></strong> riparazioni</code>