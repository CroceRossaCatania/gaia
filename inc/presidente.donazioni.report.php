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
<hr />
		<?php
		$regioni = [];
		foreach(DonazioneSede::elenco("regione") as $sede){
			if(!array_key_exists($sede->regione, $regioni)) $regioni[$sede->regione] = ["sangueIntero","plasma","multicomponenti"];

			$regioni[$sede->regione]["sangueIntero"] = $regioni[$sede->regione]["sangueIntero"] + DonazionePersonale::conta([["donazione","2"],["luogo",$sede->id]]);
			$regioni[$sede->regione]["plasma"] = $regioni[$sede->regione]["plasma"]+ DonazionePersonale::conta([["donazione","3"],["luogo",$sede->id]]);
			$regioni[$sede->regione]["multicomponenti"] = $regioni[$sede->regione]["multicomponenti"] + DonazionePersonale::conta([["donazione","4"],["donazione","5"],["donazione","6"],["donazione","7"],["donazione","8"],["donazione","9"],["donazione","10"],["luogo",$sede->id]]);
		}
		print_r($regioni);die;
		?>
        <table class="table table-striped table-bordered" id="tabellaUtenti">
            <thead>
                <th>Regione</th>
                <th>Sangue Intero</th>
				<th>Plasma</th>
				<th>Multicomponenti</th>
            </thead>
            <?php 
			
			foreach(DonazioneSede::filtraDistinctSedi('regione') as $key => $value){
				
				?>
				<tr>
                    <td><?php echo $value; ?></td>
                    <td><?php
						$sangueIntero = DonazionePersonale::conta([["donazione","2"],["luogo",$key]]);
						echo $sangueIntero ? $sangueIntero : "-";
						?></td>
                    <td><?php
						$plasma = DonazionePersonale::conta([["donazione","3"],["luogo",$key]]);
						echo $plasma ? $plasma : "-";
						?></td>
                    <td><?php
						$multicomponenti = DonazionePersonale::conta([["donazione","4"],["donazione","5"],["donazione","6"],["donazione","7"],["donazione","8"],["donazione","9"],["donazione","10"],["luogo",$key]]);
						echo $multicomponenti ? $multicomponenti : "-";
						?></td>
				</tr>
				<?php
			}
			?>
            </table>

<br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-copy muted"></i>
            Report donazioni per Ospadale
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
