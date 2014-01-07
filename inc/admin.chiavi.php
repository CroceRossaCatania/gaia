<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();

$chiavi = APIKey::elenco();

?>
<form action="?p=admin.chiavi.ok.php" method="POST">

	<div class="pull-right btn-group">
		<a href="?p=admin.chiavi.genera.php" class="btn btn-large btn-warning">
			<i class="icon-plus"></i>
			Genera nuova chiave
		</a>
		<button type="submit" class="btn btn-large btn-success">
			<i class="icon-save"></i>
			Salva modifiche
		</button>
	</div>

	<h2>Chiavi API riconosciute</h2>

	<table class="table table-bordered">

		<thead>
			<th>ID</th>
			<th>Applicazione</th>
			<th>Attiva</th>
			<th>Email</th>
			<th>Chiave</th>
			<th>#R/Limite</th>
		</thead>

		<tbody>
		<?php foreach ( $chiavi as $chiave ) { ?>

			<tr>
				<td>
					<input type="hidden" name="chiavi[]" value="<?php echo $chiave->id; ?>" />
					#<?php echo $chiave->id; ?>
				</td>
				<td>
					<input 
							type="text" class="input-medium"
							placeholder="Nome applicazione..."
							name="<?php echo $chiave->id; ?>_nome"
							required
							value="<?php echo $chiave->nome; ?>" 
						/>
				</td>
				<td>
					<input 
							type="number" class="input-mini"
							min="0" max="1" step="1"
							name="<?php echo $chiave->id; ?>_attiva"
							required
							value="<?php echo (int) $chiave->attiva; ?>" 
						/>
				</td>
				<td>
					<input 
							type="email" class="input-medium"
							placeholder="Email contatto"
							required
							name="<?php echo $chiave->id; ?>_email"
							value="<?php echo $chiave->email; ?>" 
						/>
				</td>
				<td>
					<input 
							type="text" class="input-medium" readonly="readonly"
							value="<?php echo $chiave->chiave; ?>" 
						/>
				</td>
				<td>
					<input 
							type="number" class="input-mini"
							readonly="readonly"
							value="<?php echo (int) $chiave->oggi; ?>" 
						/>
					/
					<input 
							type="number" class="input-mini"
							min="0" step="100"
							name="<?php echo $chiave->id; ?>_limite"
							required
							value="<?php echo (int) $chiave->limite; ?>" 
						/>
				</td>
			</tr>

		<?php } ?>
		</tbody>
	</table>
</form>