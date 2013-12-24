<?php

/*
 * ©2013 Croce Rossa Italiana
 */
paginaPrivata();

controllaParametri(array('id'), 'gruppi.dash&err');

$id = $_GET['id'];

?>
<script type="text/javascript"><?php require './js/obiettivo.report.reperibilita.js'; ?></script>
<div class="row-fluid">
	<form class="form-horizontal" action="?p=gruppo.utente.report.ok&id=<?php echo $id; ?>" method="POST">
		<div class="span12">
			<div class="row-fluid">
				<h2><i class="icon-time muted"></i> Genera report dei turni</h2>
				<div class="alert alert-block alert-info ">
					<div class="row-fluid">
						<span class="span12">
							<p>Con questo modulo si può generare il report dei turni eseguiti dal volontario.</p>
							<p>Specificare la data di inizio e di fine per generare un report di quell'intervallo. </p>
						</span>
					</div>
				</div>           
			</div>

			<div class="row-fluid">
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