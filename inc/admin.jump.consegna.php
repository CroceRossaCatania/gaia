<?php

paginaAdmin();


?>

<div class="row">
	<div class="span6" style="text-align: center;">

		<h2>Jump 2014</h2>
		<h3>Convalida Tesserini CRI</h3>
		<hr />

		<form action="#" id="modulo">
			<input type="text" class="input-large" style="font-size: x-large;" id="codice" autocomplete="off" /><br />
			<select id="stato" name="stato">
				<option value="<?= STAMPATO; ?>">STAMPATO, ATTIVAZIONE</option>
				<option value="<?= INVALIDATO; ?>">INVALIDATO, DISTRUZIONE</option>
			</select>
			<br />
			<button type="submit" class="btn btn-submit">Attiva tesserino</button>
		</form>

	</div>

	<div class="span6" style="text-align: center; padding-top: 20px;">
		
		<h1 id="nome"></h1>
		<img class="nascosto" id="avatar" />

	</div>

</div>

<script type="text/javascript">
$(document).ready(function() {

	$("#codice").focus();
	$("#modulo").submit(function(){

		$("#nome").text('Attendere...');

		var codice = $("#codice").val();
		setTimeout(function() {
			$("#codice").select().focus();
		}, 200);

		api('tesserino:stato', {
			codice: 	codice,
			stato: 		$("#stato").val()
		}, function(x) {
			if ( !x.risposta.ok ) {
				$("#nome").text("Tesserino non valido").addClass('text-error');
				$("#avatar").removeClass('nascosto').hide();
				return false;
			}
			$("#nome").text(x.risposta.volontario.nomeCompleto).removeClass('text-error');
			$("#avatar").attr('src', x.risposta.volontario.avatar[20]).show();

		});

		return false;

	});
});

</script>