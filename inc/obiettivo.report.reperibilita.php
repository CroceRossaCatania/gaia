<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_OBIETTIVO , APP_PRESIDENTE]);

$elenco = $me->comitatiApp ([ APP_OBIETTIVO, APP_PRESIDENTE ]);
foreach ( $elenco as $unit ){
	$t[] = $unit->locale();
}
$t = array_unique($t);

?>
<div class="row-fluid">
	<form class="form-horizontal" action="?p=obiettivo.report.reperibilita.ok" method="POST">
		<div class="span12">
			<div class="row-fluid">
				<h2><i class="icon-time muted"></i> Genera report delle reperibilità</h2>
				<div class="alert alert-block alert-info ">
					<div class="row-fluid">
						<span class="span12">
							<p>Con questo modulo si può generare il report delle reperibilità all'interno di un Comitato.</p>
							<p>Specificare la data di inizio e di fine per generare un report di quell'intervallo. </p>
						</span>
					</div>
				</div>           
			</div>

			<div class="row-fluid">
				<div class="control-group">
						<label class="control-label" for="oid">Seleziona Comitato</label>
						<div class="controls">
							<select class="input-xxlarge" id="oid" name="oid" required>
								<?php
								foreach ( $t as $numero ) { ?>
								<option value="<?php echo $numero->oid(); ?>"><?php echo $numero->nomeCompleto(); ?></option>
								<?php } ?>
							</select>   
						</div> 
					</div>

					<div class="control-group">
						<label class="control-label" for="datainizio">Data inizio </label>
						<div class="controls">
							<input class="input-medium" type="text" name="datainizio" id="datainizio" required>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="datafine">Data fine </label>
						<div class="controls">
							<input class="input-medium" type="text" name="datafine" id="datafine" required>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-large btn-success">
								<i class="icon-ok"></i>
								Genera report
							</button>
						</div>
					</div>
				</div>

			</div>
		</form>
	</div>