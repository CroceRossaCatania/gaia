<?php  
paginaPrivata();

controllaParametri(array('d'));

$d = $_GET['d'];
$tp = DonazionePersonale::id($d);
$r = $tp->donazione()->tipo;

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
          <label for="luogo"><i class="icon-road"></i> Sede</label>
        </div>
        <div class="span8">
<select id="luogo" name="luogo" class="span12" required>
	<option selected="selected" disabled=""></option>
	<?php
	foreach(DonazioneSedi::filtra([['tipo', $r]]) as $value){
		echo "<option value=\"".$value."\"";
		if($tp->luogo == $value->id) echo " selected";
		echo ">".$value->provincia.' - '.$value->nome."</option>";
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
