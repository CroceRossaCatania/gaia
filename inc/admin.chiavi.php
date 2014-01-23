<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaAdmin();

$chiavi = APIKey::elenco();

?>

<?php if ( !$chiavi ) { ?>
<div class="alert alert-block alert-error">
	<h4><i class="icon-warning-sign"></i> Chiave web non presente</h4>
	<p>Non &egrave; presente la chiave web. Non funzioneranno le API JS da browser.</p>
	<p>Per rimediare, cliccare su "Genera nuova chiave". Gaia generera' una chiave JS automaticamente.</p>
</div>
<?php } ?>

<form action="?p=admin.chiavi.ok" method="POST">

	<div class="pull-right btn-group">
		<a href="?p=admin.chiavi.genera" class="btn btn-large btn-warning"
			data-conferma="Generare davvero una nuova chiave?">
			<i class="icon-plus"></i>
			Genera nuova chiave
		</a>
		<button type="submit" class="btn btn-large btn-success">
			<i class="icon-save"></i>
			Salva modifiche
		</button>
	</div>

	<h2>Chiavi API riconosciute</h2>

	<table class="table table-condensed">

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
						<a href="?p=admin.chiavi.rigenera&id=<?php echo $chiave->id; ?>"
							data-conferma="Rigenerare la chiave <?php echo $chiave->id; ?>?"
						>
							<i class="icon-refresh"></i> Rig.
						</a>
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
					<a href="?p=admin.chiavi.cancella&id=<?php echo $chiave->id; ?>"
							data-conferma="CANCELLARE DEFINITIVAMENTE <?php echo $chiave->id; ?>?"
						>
							<i class="icon-trash"></i>
						</a>

				</td>
			</tr>

		<?php } ?>
		</tbody>
	</table>


</form>
<hr />

<p>
	<ul>
		<li><strong>Limite</strong>: 0 significa richieste illimitate.</li>
		<li><strong>Attiva</strong>: 1 chiave attiva, 0 chiave disattiva.</li>
	</ul>
</p>
