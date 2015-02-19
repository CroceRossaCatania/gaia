<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

?>

<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-copy muted"></i>
            Report donazioni per Regione
        </h2>
    </div>   
</div>
		<?php
		$regioni = [];
		foreach(DonazioneSede::elenco("regione") as $sede){
			if(!array_key_exists($sede->regione, $regioni)) $regioni[$sede->regione] = ["sangueIntero","plasma","multicomponenti"];

			$regioni[$sede->regione]["sangueIntero"] = $regioni[$sede->regione]["sangueIntero"] + DonazionePersonale::conta([["donazione","2"],["luogo",$sede->id]]);
			$regioni[$sede->regione]["plasma"] = $regioni[$sede->regione]["plasma"]+ DonazionePersonale::conta([["donazione","3"],["luogo",$sede->id]]);
			$regioni[$sede->regione]["multicomponenti"] = $regioni[$sede->regione]["multicomponenti"] + DonazionePersonale::conta([["donazione","4"],["donazione","5"],["donazione","6"],["donazione","7"],["donazione","8"],["donazione","9"],["donazione","10"],["luogo",$sede->id]]);
		}
		?>
        <table class="table table-striped table-bordered" id="tabellaUtenti">
            <thead>
                <th>Regione</th>
                <th>Sangue Intero</th>
				<th>Plasma</th>
				<th>Multicomponenti</th>
            </thead>
            <?php 
			
			foreach($regioni as $regione => $valori){ ?>
				<tr>
                    <td><?php echo $regione; ?></td>
                    <td><?php echo $valori["sangueIntero"] ? $valori["sangueIntero"] : "-"; ?></td>
                    <td><?php echo $valori["plasma"] ? $valori["plasma"] : "-"; ?></td>
                    <td><?php echo $valori["multicomponenti"] ? $valori["multicomponenti"] : "-"; ?></td>
				</tr>
				<?php
			}
			?>
            </table>
<hr />
<br/>

<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-copy muted"></i>
            Report donazioni per Provincia
        </h2>
    </div>   
</div>
		<?php
		$provincie = [];
		foreach(DonazioneSede::elenco("regione") as $sede){
			if(!array_key_exists($sede->provincia, $provincie)) { $provincie[$sede->provincia] = ["regione","sangueIntero","plasma","multicomponenti"]; $provincie[$sede->provincia]["regione"] = $sede->regione; }

			$provincie[$sede->provincia]["sangueIntero"] = $provincie[$sede->provincia]["sangueIntero"] + DonazionePersonale::conta([["donazione","2"],["luogo",$sede->id]]);
			$provincie[$sede->provincia]["plasma"] = $provincie[$sede->provincia]["plasma"]+ DonazionePersonale::conta([["donazione","3"],["luogo",$sede->id]]);
			$provincie[$sede->provincia]["multicomponenti"] = $provincie[$sede->provincia]["multicomponenti"] + DonazionePersonale::conta([["donazione","4"],["donazione","5"],["donazione","6"],["donazione","7"],["donazione","8"],["donazione","9"],["donazione","10"],["luogo",$sede->id]]);
		}
		?>
        <table class="table table-striped table-bordered" id="tabellaUtenti">
            <thead>
                <th>Regione</th>
				<th>Provincia</th>
                <th>Sangue Intero</th>
				<th>Plasma</th>
				<th>Multicomponenti</th>
            </thead>
            <?php 
			
			foreach($provincie as $provincia => $valori){ ?>
				<tr>
					<td><?php echo $valori["regione"]; ?></td>
                    <td><?php echo $provincia; ?></td>
                    <td><?php echo $valori["sangueIntero"] ? $valori["sangueIntero"] : "-"; ?></td>
                    <td><?php echo $valori["plasma"] ? $valori["plasma"] : "-"; ?></td>
                    <td><?php echo $valori["multicomponenti"] ? $valori["multicomponenti"] : "-"; ?></td>
				</tr>
				<?php
			}
			?>
            </table>
<hr />
<br/>

<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-copy muted"></i>
            Report donazioni per Città
        </h2>
    </div>   
</div>
		<?php
		$citta = [];
		foreach(DonazioneSede::elenco("regione") as $sede){
			if(!array_key_exists($sede->citta, $citta)) { $citta[$sede->citta] = ["regione","sangueIntero","plasma","multicomponenti"]; $citta[$sede->citta]["regione"] = $sede->regione; $citta[$sede->citta]["provincia"] = $sede->provincia; }

			$citta[$sede->citta]["sangueIntero"] = $citta[$sede->citta]["sangueIntero"] + DonazionePersonale::conta([["donazione","2"],["luogo",$sede->id]]);
			$citta[$sede->citta]["plasma"] = $citta[$sede->citta]["plasma"]+ DonazionePersonale::conta([["donazione","3"],["luogo",$sede->id]]);
			$citta[$sede->citta]["multicomponenti"] = $citta[$sede->citta]["multicomponenti"] + DonazionePersonale::conta([["donazione","4"],["donazione","5"],["donazione","6"],["donazione","7"],["donazione","8"],["donazione","9"],["donazione","10"],["luogo",$sede->id]]);
		}
		?>
        <table class="table table-striped table-bordered" id="tabellaUtenti">
            <thead>
                <th>Regione</th>
				<th>Provincia</th>
				<th>Città</th>
                <th>Sangue Intero</th>
				<th>Plasma</th>
				<th>Multicomponenti</th>
            </thead>
            <?php 
			
			foreach($citta as $city => $valori){ ?>
				<tr>
					<td><?php echo $valori["regione"]; ?></td>
					<td><?php echo $valori["provincia"]; ?></td>
                    <td><?php echo $city; ?></td>
                    <td><?php echo $valori["sangueIntero"] ? $valori["sangueIntero"] : "-"; ?></td>
                    <td><?php echo $valori["plasma"] ? $valori["plasma"] : "-"; ?></td>
                    <td><?php echo $valori["multicomponenti"] ? $valori["multicomponenti"] : "-"; ?></td>
				</tr>
				<?php
			}
			?>
            </table>
<hr />
<br/>

<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-copy muted"></i>
            Report donazioni per Ospedale
        </h2>
    </div>   
</div>
<hr />
        <table class="table table-striped table-bordered" id="tabellaUtenti">
            <thead>
                <th>Regione</th>
                <th>Provincia</th>
                <th>Città</th>
				<th>Ospedale</th>
                <th>Sangue Intero</th>
				<th>Plasma</th>
				<th>Multicomponenti</th>
            </thead>
            <?php 
			foreach(DonazioneSede::elenco("regione") as $sede){
				
				?>
				<tr>
                    <td><?php echo $sede->regione; ?></td>
                    <td><?php echo $sede->provincia; ?></td>
                    <td><?php echo $sede->citta; ?></td>
                    <td><?php echo $sede->nome; ?></td>
                    <td><?php
						$sangueIntero = DonazionePersonale::conta([["donazione","2"],["luogo",$sede->id]]);
						echo $sangueIntero ? $sangueIntero : "-";
						?></td>
                    <td><?php
						$plasma = DonazionePersonale::conta([["donazione","3"],["luogo",$sede->id]]);
						echo $plasma ? $plasma : "-";
						?></td>
                    <td><?php
						$multicomponenti = DonazionePersonale::conta([["donazione","4"],["donazione","5"],["donazione","6"],["donazione","7"],["donazione","8"],["donazione","9"],["donazione","10"],["luogo",$sede->id]]);
						echo $multicomponenti ? $multicomponenti : "-";
						?></td>
				</tr>
				<?php
			}
			?>
            </table>
