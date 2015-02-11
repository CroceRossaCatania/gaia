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
		<label for="sedeRegione"><i class="icon-road"></i> Regione</label>
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
<?php 
$t = [];
foreach ( DonazioneSede::filtraDistinctSedi('provincia',[['regione',"Sicilia"]]) as $value ) {
            $t[] = $value;
        }
print_r($t);
?>
	<div id="provincia" class="row-fluid" style="display: none;">
		<div class="span4 centrato">
		<label for="sedeProvincia"><i class="icon-road"></i> Provincia</label>
		</div>
		<div class="span8">
		<select id="sedeProvincia" name="sedeProvincia" class="span12" required>
			<option selected="selected" disabled=""></option>
			<?php
			foreach(DonazioneSede::filtraDistinctSedi('provincia') as $value){
				echo "<option value=\"".$value."\">".$value."</option>";
			}
			?>
		</select>
		</div>
	</div>

	<div id="citta" class="row-fluid" style="display: none;">
		<div class="span4 centrato">
		<label for="sedeCitta"><i class="icon-road"></i> Città</label>
		</div>
		<div class="span8">
		<select id="sedeCitta" name="sedeCitta" class="span12" required>
			<option selected="selected" disabled=""></option>
			<?php
			foreach(DonazioneSede::filtraDistinctSedi('citta') as $value){
				echo "<option value=\"".$value."\">".$value."</option>";
			}
			?>
		</select>
		</div>
	</div>

	<div id="ospedale" class="row-fluid" style="display: none;">
		<div class="span4 centrato">
		<label for="sede"><i class="icon-road"></i> Ospedale</label>
		</div>
		<div class="span8">
		<select id="sede" name="sede" class="span12" required>
			<option selected="selected" disabled=""></option>
			<?php
			foreach(DonazioneSede::filtraDistinctSedi('nome') as $key => $value){
				echo "<option value=\"".$key."\">".$value."</option>";
			}
			?>
		</select>
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
