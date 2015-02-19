<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

?>

<br/>
<div class="row-fluid">
    <div class="span8">
        <h2>
            <i class="icon-copy muted"></i>
            Report donazioni
        </h2>
    </div>   
</div>
<br/>

    <div class="span8">Per Ospedale</div>   

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
