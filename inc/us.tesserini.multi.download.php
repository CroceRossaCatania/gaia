<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();

set_time_limit(0);

$urls = json_decode($sessione->tesserini);
if (!$urls) {
	redirect("us.tesserini");
}

?>

<div class="row">
	<div class="span6 offset3 allinea-centro">

		<h2>Scaricamento dei tesserini</h2>
		<p>Attendi mentre i tesserini vengono scaricati.</p>

		<h4 class="text-warning"> 
			<span class="text-error">
				<span id="numero-attuale">0</span> di <?= count($urls); ?>
			</span>
			&mdash;
			<span class="text-error" id="minuti">
				<?= round((count($urls) * TESSERINI_SECONDI)/60, 0); ?>
			</span>
			minuti e
			<span class="text-error" id="secondi_rim">
				(?)
			</span>
			secondi
			rimanenti
			&mdash;
			<span class="text-error" id="percentuale">0%</span>
			completo
		</h4>


		<p>
			<div class="progress progress-striped active">
			  <div class="bar" style="width: 40%;"></div>
			</div>
		</p>

		<label class="btn btn-small" for="pausa">Metti in pausa &nbsp; <input type="checkbox" id="pausa" value="1" /></label>
		
		<p>&nbsp;</p>

		<div id="finito" class="alert alert-success nascosto alert-block">
			<h4><i class="icon-check"></i> <?= count($urls); ?> tesserini scaricati.</h4>
			<p>Grazie per aver usato questo strumento.</p>
			<a href="/?p=us.tesserini&multi=<?= count($urls); ?>" class="btn btn-success btn-block">
				Torna all'elenco dei tesserini
			</a>
		</div>

		<script type="text/javascript">
			var urls = <?= json_encode($urls); ?>;
			var attesa = 0;
			var secondi = <?= TESSERINI_SECONDI; ?>;
			var numero_attuale = 0;
			var timing = 200;
			var tick = secondi * 1000 / timing;
			var tick_attuale = tick/2;
			var finito = 0;

			function scaricaTesserini() {
				var pausa = !!$("#pausa:checked").length;
				tick_attuale += 1;

				// Aggiorna contatori
				$("#numero-attuale").text(numero_attuale);
				var secondi_rimanenti = (urls.length-numero_attuale)*secondi;
				$("#minuti").text(Math.floor(secondi_rimanenti/60));
				$("#secondi_rim").text(Math.round(secondi_rimanenti%60));
				percentuale = Math.round10((numero_attuale/urls.length*100) , -1);
				$("#percentuale").text(percentuale + "%");
				percentuale = Math.round(percentuale) + "%";
				$(".bar").css('width', percentuale);
				if ( pausa || finito ) {
					$(".progress").removeClass("progress-striped");
				} else {
					$(".progress").removeClass("progress-striped").addClass("progress-striped");
				}

				// non in pausa, non scaricando, non meno di X secondi
				if (pausa || tick_attuale < tick || finito) {
					return;
				}


				tick_attuale = 0;
				$.fileDownload(urls[numero_attuale]);
				numero_attuale++;

				if (numero_attuale == urls.length) {
					finito = true;
					$("#finito").removeClass("nascosto");
				}

			}


			$(document).ready(function(){
				setInterval(scaricaTesserini, timing);
			});
		</script>
	</div>
</div>