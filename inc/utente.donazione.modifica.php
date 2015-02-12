<?php  
paginaPrivata();

controllaParametri(array('d'));

$d = $_GET['d'];
$tp = DonazionePersonale::id($d);
$r = $tp->donazione()->tipo;
$l = DonazioneSede::id($tp->luogo);

$donazioni = $conf['donazioni'][$d];
?>
<form action="?p=utente.donazione.modifica.ok&d=<?php echo $d; ?>" method="POST">
  <div class="modal fade automodal">
    <div class="modal-header">
      <h3>Modifica Donazione</h3>
    </div>
    <div class="modal-body">
      <div class="row-fluid">
        <div class="span4 centrato">
          <label for="data"><i class="icon-calendar"></i> Donazione</label>
        </div>
        <div class="span8">
	  <input id="data" class="span12" name="data" type="text" <?php if ($donazioni[3]) { ?>required<?php } ?> value="<?php if($tp->data) echo date('d/m/Y', $tp->data); ?>" />
        </div>
      </div>
      <div class="row-fluid">
		<div class="span4 centrato">
          <label for="sedeRegione">Regione</label>
        </div>
        <div class="span8">
			<select id="sedeRegione" name="sedeRegione" class="span12" required>
				<?php
				foreach(DonazioneSede::filtraDistinctSedi('regione') as $value){
					echo "<option value=\"".$value."\"";
					if($l->regione == $value) echo " selected";
					echo ">".$value."</option>";
				}
				?>
			</select>
        </div>
      </div>

		<div id="provincia" class="row-fluid">
			<div class="span4 centrato">
			<label for="sedeProvincia">Provincia</label>
			</div>
			<div class="span8">
			<select id="sedeProvincia" name="sedeProvincia" class="span12" required>
				<?php
				foreach(DonazioneSede::filtraDistinctSedi('provincia',[['regione',$l->regione]]) as $value){
					echo "<option value=\"".$value."\"";
					if($l->provincia == $value) echo " selected";
					echo ">".$value."</option>";
				}
				?>
			</select>
			</div>
		</div>

		<div id="citta" class="row-fluid">
			<div class="span4 centrato">
			<label for="sedeCitta">Citt&agrave;</label>
			</div>
			<div class="span8">
			<select id="sedeCitta" name="sedeCitta" class="span12" required>
				<?php
				foreach(DonazioneSede::filtraDistinctSedi('citta',[['provincia',$l->provincia]]) as $value){
					echo "<option value=\"".$value."\"";
					if($l->citta == $value) echo " selected";
					echo ">".$value."</option>";
				}
				?>
			</select>
			</div>
		</div>

		<div id="ospedale" class="row-fluid">
			<div class="span4 centrato">
			<label for="sede"><i class="icon-road"></i> Ospedale</label>
			</div>
			<div class="span8">
			<select id="sede" name="sede" class="span12" required>
				<?php
				foreach(DonazioneSede::filtraDistinctSedi('nome',[['citta',$l->citta]]) as $key => $value){
					echo "<option value=\"".$key."\"";
					if($tp->luogo == $key) echo " selected";
					echo ">".$value."</option>";
				}
				?>
			</select>
			</div>
		</div>

    </div>
    <div class="modal-footer">
      <a href="?p=utente.donazioni&d=<?php echo $r; ?>" class="btn">Annulla</a>
      <button type="submit" class="btn btn-primary">
        <i class="icon-save"></i> Modifica
      </button>
    </div>
  </div>

</form>
