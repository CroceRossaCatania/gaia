<?php


/*
 * ©2013 Croce Rossa Italiana
 */

paginaAdmin();

set_time_limit(0);
?>
<h3><i class="icon-wrench muted"></i> Manutenzione attività</h3>

<code><pre>Rimozione attività con dati incompleti:
<?php
$attivita = Attivita::elenco();
$eseguiti=0;
$nAutorizzazioni = 0;
$nPartecipazioni = 0;
$nTurni = 0;
$nAttivita = 0;
echo "Start manutenzione attività:<br/>";
foreach( $attivita as $a ){
	$comitato = $a->comitato();
	if( $comitato ){
		/*try {
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
    	} */
		continue;
	}else{
		echo "Inizio rimozione attività con dati incompleti: ID: ", $a->id, $a->nome;
		$turni = Turno::filtra([['attivita', $a]]);
		foreach( $turni as $turno ){
			$partecipazioni = Partecipazione::filtra([['turno', $turno]]);
			foreach( $partecipazioni as $partecipazione ){
				$autorizzazioni = Autorizzazione::filtra(['partecipazione', $partecipazione]);
				foreach( $autorizzazioni as $autorizzazione ){
					$autorizzazione->cancella();
					$nAutorizzazioni++;
				}
				echo " - Autorizzazioni rimosse";
				$partecipazione->cancella();
				$nPartecipazioni++;
			}
			echo " - Partecipazioni rimosse";
			$turno->cancella();		
			$nTurni++;
		}
		echo " - Turni rimossi";
		$a->cancella();
		$nAttivita++;
	}
	echo " - Attività rimosse - Operazione completata!<br/>";
}
?>
Ho rimosso <strong><?= $nAutorizzazioni; ?></strong> turni, <strong><?= $nPartecipazioni; ?></strong> partecipazioni, <strong><?= $nTurni; ?></strong> turni, <strong><?= $nAttivita; ?></strong> attivita.
Eseguite <strong><?= $eseguiti; ?></strong> riparazioni.</pre></code>