<?php

/*
* ©2013 Croce Rossa Italiana
*/

if (isset($_GET['d'])) {
    $d = (int) $_GET['d'];
} else {
    $d = 0;
}
paginaPrivata();

?>
<div class="row-fluid">
<div class="span3">
<?php menuVolontario(); ?>
</div>
<div class="span9">
<?php if ( $d == 0 ) { ?>

<div class="alert alert-info">
<i class="icon-comments"></i>
Vorresti contribuire al miglioramento della sezione <strong>donazioni</strong>?
<p></p>
<p>Per favore contattaci a <a href="mailto:feedback.donazionisangue@gaia.cri.it?subject=Feedback+donazioni+sangue">feedback.donazionisangue@gaia.cri.it</a></p> .
</div>


<h2><i class="icon-beaker muted"></i> Donazioni di sangue</h2>
<div class="alert alert-block alert-error">
<div class="row-fluid">
<span class="span12">
<h4>Anche tu doni il sangue ?</h4>
<p>Con questo modulo potrai inserire e tenere sotto controllo le tue donazioni!</p>
<p>Seleziona la data, il tipo di donazione effettuata e dove hai donato.</p>
</span>
</div>
</div>
<?php } //elseif ($d == 1) { } ?>

<?php $anagrafica = DonazioneAnagrafica::filtra([['volontario',$me->id]]); ?>

<div class="row-fluid">
	<div class="span12">
		<h3><i class="icon-edit muted"></i> Anagrafica donatore</h3>
		<?php if ( isset($_GET['ok']) ) { ?>
			<div class="alert alert-success">
				<i class="icon-save"></i> <strong>Salvato</strong>.
				Le modifiche richieste sono state memorizzate con successo.
			</div>
		<?php } else { ?>
			<div class="alert alert-block alert-info">
				<h4><i class="icon-question-sign"></i> Qualcosa è sbagliato?</h4>
				<p>Se qualche informazione è errata e non riesci a modificarla,
					<a href="?p=utente.supporto"><i class="icon-envelope-alt"></i> clicca qui </a> per ricevere supporto.</p>
			</div>
		<?php } ?>

		<form class="form-horizontal" action="?p=utente.donazione.anagrafica.ok" method="POST">
			<div class="control-group">
				<label class="control-label" for="inputSangueGruppo">Gruppo Sanguigno</label>
				<div class="controls">
					<select id="inputSangueGruppo" name="inputSangueGruppo" required>
						<option selected="selected" disabled=""></option>
						<?php
						foreach($conf['anagrafica_donatore']['sangue_gruppo'] as $key => $value){
							if ( $value !== null ) {
								echo "<option value=\"".$key."\"";
								if(count($anagrafica) AND $anagrafica[0]->sangue_gruppo == $key) echo " selected";
								echo ">".$value."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputFattoreRH">Fattore RH</label>
				<div class="controls">
					<select id="inputFattoreRH" name="inputFattoreRH">
						<option selected="selected"></option>
						<?php
						foreach($conf['anagrafica_donatore']['fattore_rh'] as $key => $value){
							if ( $value !== null ) {
								echo "<option value=\"".$key."\"";
								if(count($anagrafica) AND $anagrafica[0]->fattore_rh == $key) echo " selected";
								echo ">".$value."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputFenotipoRH">Fenotipo RH</label>
				<div class="controls">
					<select id="inputFenotipoRH" name="inputFenotipoRH">
						<option selected="selected"></option>
						<?php
						foreach($conf['anagrafica_donatore']['fanotipo_rh'] as $key => $value){
							if ( $value !== null ) {
								echo "<option value=\"".$key."\"";
								if(count($anagrafica) AND $anagrafica[0]->fanotipo_rh == $key) echo " selected";
								echo ">".$value."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputKell">Kell</label>
				<div class="controls">
					<select id="inputKell" name="inputKell">
						<option selected="selected"></option>
						<?php
						foreach($conf['anagrafica_donatore']['kell'] as $key => $value){
							if ( $value !== null ) {
								echo "<option value=\"".$key."\"";
								if(count($anagrafica) AND $anagrafica[0]->kell == $key) echo " selected";
								echo ">".$value."</option>";
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputCodiceSIT">Codice SIT</label>
				<div class="controls">
					<input type="text" class="input-small" name="inputCodiceSIT" id="inputCodiceSIT" value="<?php if(count($anagrafica) AND $anagrafica[0]->codice_sit) echo $anagrafica[0]->codice_sit; ?>">
				</div>
			</div>

			<?php
			$sedeSIT = (count($anagrafica) AND $anagrafica[0]->sede_sit) ? new DonazioneSede($anagrafica[0]->sede_sit) : false;
			?>
			<div class="control-group">
				<label class="control-label" for="inputSedeSIT">Regione Sede SIT</label>
				<div class="controls">
					<select id="inputSedeSITRegione" name="inputSedeSITRegione">
						<option selected="selected"></option>
						<?php
						foreach(DonazioneSede::filtraDistinctSedi('regione') as $value){
							echo "<option value=\"".$value."\"";
							if(($sedeSIT !== false) AND ($sedeSIT->regione == $value)) echo " selected";
							echo ">".$value."</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div id="SedeSITProvincia" class="control-group" <?php if($sedeSIT === false) echo 'style="display: none;"'; ?>>
				<label class="control-label" for="inputSedeSIT">Provincia Sede SIT</label>
				<div class="controls">
					<select id="inputSedeSITProvincia" name="inputSedeSITProvincia">
					<?php
					if($sedeSIT !== false){
						foreach(DonazioneSede::filtraDistinctSedi("provincia",[["regione",$sedeSIT->regione]]) as $value){
							echo "<option value=\"".$value."\"";
							if($sedeSIT->provincia == $value) echo " selected";
							echo ">".$value."</option>";
						}
					}
					?>
					</select>
				</div>
			</div>
			<div id="SedeSITCitta" class="control-group" <?php if($sedeSIT === false) echo 'style="display: none;"'; ?>>
				<label class="control-label" for="inputSedeSIT">Città Sede SIT</label>
				<div class="controls">
					<select id="inputSedeSITCitta" name="inputSedeSITCitta">
					<?php
					if($sedeSIT !== false){
						foreach(DonazioneSede::filtraDistinctSedi("citta",[["provincia",$sedeSIT->provincia]]) as $value){
							echo "<option value=\"".$value."\"";
							if($sedeSIT->citta == $value) echo " selected";
							echo ">".$value."</option>";
						}
					}
					?>
					</select>
				</div>
			</div>
			<div id="SedeSITOspedale" class="control-group" <?php if($sedeSIT === false) echo 'style="display: none;"'; ?>>
				<label class="control-label" for="inputSedeSIT">Unit&agrave; di raccolta</label>
				<div class="controls">
					<select id="inputSedeSIT" name="inputSedeSIT">
					<?php
					if($sedeSIT !== false){
						foreach(DonazioneSede::filtraDistinctSedi("nome",[["citta",$sedeSIT->citta]]) as $key => $value){
							echo "<option value=\"".$key."\"";
							if($anagrafica[0]->sede_sit == $key) echo " selected";
							echo ">".$value."</option>";
						}
					}
					?>
					</select>
				</div>
			</div>
			<div class="form-actions">
				<?php if($a!=1){ ?>
					<button type="submit" class="btn btn-success btn-large">
						<i class="icon-save"></i>
						Salva modifiche
					</button>
			   <?php }?>
			</div>
		</form>
	</div>
</div>

<?php $donazioni = $conf['donazioni'][$d]; ?>

<div id="step1">
	<div class="alert alert-block alert-success" <?php if ($donazioni[2]) { ?>data-richiediDate<?php } ?>>
	<div class="row-fluid">
	<span class="span3">
	<label for="cercaDonazione">
	<span style="font-size: larger;">
	<i class="icon-search"></i>
	<strong>Aggiungi</strong>
	</span>
	</label>

	</span>
	<span class="span9">
	<select id="tipo" name="tipo" class="span12" required>
		<option selected="selected" disabled=""></option>
		<?php
		foreach(Donazione::filtra([['tipo', $d]]) as $value){
			echo "<option value=\"".$value."\">".$value->nome."</option>";
		}
		?>
	</select>
	</span>
	</div>
	</div>
</div>
<div id="step2" style="display: none;">
	<form action='?p=utente.donazione.nuovo' method="POST">
	<input type="hidden" name="idDonazione" id="idDonazione" />
	<div class="alert alert-block alert-success">
	<div class="row-fluid">
	<h4><i class="icon-question-sign"></i> Quando e dove hai donato...</h4>
	</div>
	<hr />
	<div class="row-fluid">
	<div class="span4 centrato">
	<label for="data"><i class="icon-calendar"></i> Data donazione</label>
	</div>
	<div class="span8">
	<input id="data" class="span12" name="data" type="text" <?php if ($donazioni[3]) { ?>required<?php } ?> value="" />
	</div>
	</div>
	<div class="row-fluid">
		<div class="span4 centrato">
		<label for="sedeRegione">Regione</label>
		</div>
		<div class="span8">
		<select id="sedeRegione" name="sedeRegione" class="span12" required>
			<option selected="selected" disabled=""></option>
			<?php
			foreach(DonazioneSede::filtraDistinctSedi('regione') as $value){
				echo "<option value=\"".$value."\">".$value."</option>";
			}
			?>
		</select>
		</div>
	</div>

	<div id="provincia" class="row-fluid" style="display: none;">
		<div class="span4 centrato">
		<label for="sedeProvincia">Provincia</label>
		</div>
		<div class="span8">
		<select id="sedeProvincia" name="sedeProvincia" class="span12" required></select>
		</div>
	</div>

	<div id="citta" class="row-fluid" style="display: none;">
		<div class="span4 centrato">
		<label for="sedeCitta">Città</label>
		</div>
		<div class="span8">
		<select id="sedeCitta" name="sedeCitta" class="span12" required></select>
		</div>
	</div>

	<div id="ospedale" class="row-fluid" style="display: none;">
		<div class="span4 centrato">
		<label for="sede"><i class="icon-road"></i> Unit&agrave; di raccolta</label>
		</div>
		<div class="span8">
		<select id="sede" name="sede" class="span12" required></select>
		</div>
	</div>

	<div class="row-fluid">
	<div class="span4 offset8">
	<button type="submit" class="btn btn-success">
	<i class="icon-plus"></i>
	Aggiungi la donazione
	</button>
	</div>
	</div>
	</div>
</div>
<div class="row-fluid">
<div class="span12">
<?php $ddd = $me->donazioniTipo($d); ?>
<h3><i class="icon-list muted"></i> Nelle mie donazioni <span class="muted"><?php echo count($ddd); ?> inserite</span></h3>
<table class="table table-striped">
<?php foreach ( $ddd as $donazione ) { ?>
<tr <?php if (!$donazione->tConferma) { ?>class="warning"<?php } ?>>
<td><strong><?php echo $donazione->donazione()->nome; ?></strong></td>
<td><?php echo $conf['donazioni'][$donazione->donazione()->tipo][0]; ?></td>
<?php if ($donazione->tConferma) { ?>
<td>
<abbr title="<?php echo date('d-m-Y H:i', $donazione->tConferma); ?>">
<i class="icon-ok"></i> Confermato
</abbr>
</td>
<?php } else { ?>
<td><i class="icon-time"></i> Pendente</td>
<?php } ?>
<td><small>
<i class="icon-calendar muted"></i>
<?php echo date('d-m-Y', $donazione->data); ?>
<br />
<i class="icon-road muted"></i>
<?php echo DonazioneSede::by('id',$donazione->luogo)->provincia.' - '.DonazioneSede::by('id',$donazione->luogo)->nome; ?>
<br />
</small></td>
<td>
<div class="btn-group">
<?php if ( !$donazione->tConferma) { ?>
<a href="?p=utente.donazione.modifica&d=<?php echo $donazione->id; ?>" title="Modifica la donazione" class="btn btn-small btn-info">
<i class="icon-edit"></i>
</a>
<?php } ?>
<a href="?p=utente.donazione.cancella&id=<?php echo $donazione->id; ?>" title="Cancella la donazione" class="btn btn-small btn-warning">

<i class="icon-trash"></i>
</a>
</div>
</td>
</tr>
<?php } ?>
</table>

</div>
</div>

</div>
</div>
