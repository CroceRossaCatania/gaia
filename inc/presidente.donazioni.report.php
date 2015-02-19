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
                    <td><?php echo $sede[0]->regione; ?></td>
                    <td><?php echo $sede[0]->provincia; ?></td>
                    <td><?php echo $sede[0]->citta; ?></td>
                    <td><?php echo $sede[0]->nome; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
				</tr>
				<?php
			}
			?>
            </table>
