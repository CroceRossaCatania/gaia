<?php  

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI , APP_PRESIDENTE]);

$parametri = array('t', 'v');
controllaParametri($parametri, 'presidente.donazioni&err');

$t = $_GET['t'];
$v = $_GET['v'];  
$tp = DonazionePersonale::id($t);
$r = $tp->donazione()->tipo;
?>
<script type="text/javascript"><?php require './assets/js/utente.donazione.modifica.js'; ?></script>
<form action="?p=presidente.donazione.modifica.ok&t=<?php echo $t; ?>&v=<?php echo $v; ?>" method="POST">
<!-- presidente.titolo.modifica.ok -->
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
          <input id="data" class="span12" name="data" type="text"  value="<?php if($tp->data) echo date('d/m/Y', $tp->data); ?>" />
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
	foreach(DonazioneSede::filtra([['tipo', $r]].'provincia') as $value){
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
      <a href="?p=presidente.utente.visualizza&id=<?php echo $v; ?>" class="btn">Annulla</a>
      <button type="submit" class="btn btn-primary">
        <i class="icon-save"></i> Modifica
      </button>
    </div>
  </div>
</form>
