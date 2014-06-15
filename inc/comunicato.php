<?php

/*
 * ©2014 Croce Rossa Italiana
 */

if ($me) {
	$sessione->deadline = time();
}

$_titolo = "Nota dalla Squadra di Gaia: Interruzione dello Sviluppo, del Supporto e dell'Assistenza per il Progetto Gaia";

?>

<style>
	/* Dello stile veloce...*/

	#sviluppatori li {
		padding-bottom: 8px;
	}
	#comunicato {
		text-align: justify;
		font-family: 'Cardo';
		padding: 25px;
		box-shadow: 5px 5px 5px gray;
		background-color: #F9F9F9;
		font-size: 115%;
	}
	#grafico {
		padding: 20px 0px;
		font-style: italic;
		text-align: center;
	}
</style>

<link href='http://fonts.googleapis.com/css?family=Cardo:400,700,400italic' rel='stylesheet' type='text/css'>

<div id="fb-root"></div>

<div class="row-fluid">

	<div class="span7" id="comunicato">

		<div style="text-align: center;">
			<p><strong>15 giugno 2014</strong> (aggiornato, ore 16.50)</p>
			<h1>Nota della Squadra di Gaia</h1>
			<h4>Rallentamento temporaneo dello Sviluppo, del Supporto<br />e dell'assistenza per il progetto Gaia</h4>
		</div>

		<hr />

		<p>
		Ciao <?php echo (( $me instanceOf Utente ) ? $me->nome : "Volontario/a"); ?>,<br/>
		come avrai potuto notare, in queste ultime settimane il portale che ospita il Progetto Gaia
		è poco responsivo e la squadra di Supporto, nonostante gli sforzi, non è in grado di fornire una soluzione tempestiva.
		</p>

		<h3>Cosa è successo?</h3>
		<p>
		Negli ultimi mesi un grandissimo numero di Comitati ha aderito al Progetto e di conseguenza il numero di volontari e soci registrati ha superato i 
		<strong>56.000</strong>, facendo crescere drasticamente il carico di lavoro sull’infrastruttura informatica e rendendo <strong>improrogabile</strong> 
		l’avvio di una serie di interventi e di migliorie per permettere al sistema di continuare a servire l’utenza attraverso un <strong>adeguamento
		informatico necessario</strong> (server, macchine più potenti, costi di licenze, strumenti di sviluppo, ecc.).
		Siamo sempre stati abituati a lavorare in economia ed a sfruttare al meglio le risorse presenti, 
		ma non &egrave; più pensabile che il Progetto possa servire tutta Italia con le stesse risorse con le quali è stati avviato.
		</p>

		<div id="grafico">
			<img src="/img/comunicato_img1.png" title="Grafico delle Pagine servite" alt="Grafico delle pagine servite" class="img-polaroid" />
			<br />
			<p>Grafico delle pagine servite per giorno dal Progetto, attuali 32mila/giorno</p>
		</div>


		<h3>Cosa stiamo facendo e cosa succeder&agrave;?</h3>
		<p>
		La Squadra ha effettuato un'analisi delle problematiche, stilando varie relazioni tecniche sulle necessit&agrave; per poter proseguire nello Sviluppo del Progetto GAIA.
		Per rendere le acquisizioni piu&ugrave; rapide, consci che i tempi della Pubblica Amministrazione su cose cos&igrave; tecniche spesso non ci aiutano, ci stiamo anche
		interrogando per trovare altre linee di finanziamento al progetto, anche attraverso raccolte esterne.
		</p>

		<p>
		In questo momento per&ograve; tali necessit&agrave; sono cruciali per
		 far sviluppare nuove funzionalit&agrave; risolvere le problematiche attuali ed assicurare l'assistenza che arriver&agrave; tramite i canali di supporto in tempi stretti.
		</p>

		<p>
		<strong>
		Il nostro Coordinatore di Progetto ci ha oggi assicurato che sono state avviate dagli uffici competenti le 
		procedure per l’acquisizione di licenze, server, ecc, e che queste risorse dovrebbero essere disponibili
		e andare a regime entro la fine di giugno.</strong></p>


		<h3>Quali funzionalit&agrave; vedranno la luce?</h3>
		<p>
		Moltissime funzionalità di Gaia in questi mesi sono state sviluppate partendo dai regolamenti
		 e dalle esigenze dei comitati CRI. Alcune di queste, ormai pronte per essere rilasciate, saranno
		 messe a disposizione appena potranno essere adeguatamente mantenute.</p>
		<p>
		Le funzionalità sviluppate e non ancora attivabili sul sistema sono le seguenti:
		</p>
		<p>
		<ul>
			<li>Sistema di gestione dei corsi base (<a href="https://github.com/CroceRossaCatania/gaia/pull/1209" target="_new">completo</a>);</li>
			<li>Prima versione dell'Applicazione Ufficiale per dispositivi Android (<a href="https://play.google.com/store/apps/details?id=it.gaiacri.mobile" target="_new">completa, disponibile su Play Store</a>);</li>
			<li>Sistema di gestione degli aspiranti volontari con la funzionalità &laquo;Cerca il corso base più
			vicino a te&raquo; (<a href="https://github.com/CroceRossaCatania/gaia/pull/1209" target="_new">completo</a>);</li>
			<li>Sistema di emissione, verifica e gestione dei tesserini per volontari e soci ordinari (<a href="https://github.com/CroceRossaCatania/gaia/pull/1209" target="_new">completo</a>);</li>
			<li>Sistema di gestione delle donazioni del sangue sviluppato dal gruppo di lavoro 
			sulle donazioni (<a href="https://github.com/CroceRossaCatania/gaia/pull/1209" target="_new">completo</a>);</li>
			<li>Adeguamento del portale alle linee guida di comunicazione istituzionale (<a href="https://github.com/CroceRossaCatania/gaia/pull/1209" target="_new">completo</a>)</li>
			<li>Nuovo sistema di gestione delle quote dei volontari che rispetta le indicazioni
			legate alla provatizzazione dei comitati CRI (<a href="https://github.com/CroceRossaCatania/gaia/pull/1209" target="_new">completo</a>);</li>
			<li>Introduzione di una timeline con le ultime informazioni sul mondo CRI (<a href="https://github.com/CroceRossaCatania/gaia/pull/1209" target="_new">completo</a>);</li>
			<li>Gestione da parte dell'ufficio soci di trasferimenti, estensioni e riserve (<a href="https://github.com/CroceRossaCatania/gaia/pull/1209" target="_new">completo</a>);</li>
			<li>Revisione del sistema di gestione degli elenchi, degli export e delle email (<a href="https://github.com/CroceRossaCatania/gaia/pull/1209" target="_new">completo</a>);</li>
			<li>Introduzione del sistema di gestione dei provvedimenti disciplinari e 
			delle riammissioni secondo le ultime direttive (<a href="https://github.com/CroceRossaCatania/gaia/pull/1209" target="_new">completo</a>);</li>
			<li>Applicazione Ufficiale per iPhone ed iPad (in lavorazione).
		</ul>
		</p>


		<p>
		<strong>E tanto altro ancora...</strong><br/>
		Tante sono poi le funzionalità di Gaia in fase di sviluppo, a cominciare dal sistema di gestione
		unificato per la formazione interna ed esterna all'associazione, passando per il modulo di 
		gestione delle visite mediche e degli aspetti sanitari che avrebbe integrato tutte le procedure
		di sicurezza per la gestione dei dati sensibili, arrivando al modulo per la gestione di vestiario
		e magazzini interni al comitato e tanto altro ancora.
		</p>

		<h3>Ringraziamenti e pazienza...</h3>
		<p>
		Vorremmo ringraziare tutti gli utenti di Gaia che in questi mesi stanno contribuendo a segnalarci 
		bug e malfunzionamenti di ogni genere via email, telefono, github, facebook e con ogni altro 
		strumento. Vorremmo inoltre ringraziare tutte le persone che ci continuano a suggerire funzionalità e 
		miglioramenti da introdurre nel sistema all'indirizzo <a href="mailto:feedback@gaia.cri.it">feedback@gaia.cri.it</a>,
		nonch&eacute; i presidenti e gli 
		uffici soci dei comitati che hanno aderito al progetto e hanno avuto la pazienza di attendere le 
		risposte del supporto quando avevano qualche problema, di compilare in maniera corretta gli i 
		formati e di spiegare ai loro volontari come utilizzare il sistema. Da ultimo ci teniamo a ringraziare 
		tutto lo staff dell'helpdesk di primo livello che in questi mesi ci ha aiutato a smaltire il 
		numero sempre maggiore di ticket da parte degli utenti.
		</p>

		<blockquote style="font-weight: bold;">
			Siamo ad un cruciale giro di boa e, sperando che gli uffici accelerino al massimo queste acquisizioni,
			visto l'entusiasmo dei Volontari che hanno creduto nel progetto e gli ottimi risultati raggiunt
			in poco tempo e con un budget nullo, vi chiediamo di pazientare ancora qualche giorno (e non odiarci)
			fino a che il nostro GAIA decolli definitivamente. 
		</blockquote>

		<p>&nbsp;</p>

		<p style="font-style: italic;">
		In fede,<br />
		Gli Sviluppatori e la Squadra di Supporto di Gaia:
		</p>

		<ul id="sviluppatori">
			<li><strong>Alberto Copelli</strong>
				<a href="https://github.com/ciopper90" target="_new" class="icon-github"></a><br />
				 Sviluppo app Android</li>

			<li><strong>Luca De Sano</strong> 
				<a href="https://facebook.com/luca.desano" target="_new" class="icon-facebook-sign"></a>
				<a href="https://github.com/luca-dex" target="_new" class="icon-github"></a><br />
				 Sviluppo GAIA e Supporto</li>

			<li><strong>Federico D’Urso</strong> 
				<a href="https://facebook.com/ico88" target="_new" class="icon-facebook-sign"></a>
				<a href="https://github.com/ico88" target="_new" class="icon-github"></a><br />
				 Sviluppo GAIA e Supporto</li>

			<li><strong>Alfio Emanuele Fresta</strong> 
				<a href="https://facebook.com/alfio.emanuele" target="_new" class="icon-facebook-sign"></a>
				<a href="https://github.com/AlfioEmanueleFresta" target="_new" class="icon-github"></a><br />
				 Sviluppo GAIA e Supporto API</li>

			<li><strong>Paolo Giustiniani</strong> 
				<a href="https://github.com/PaoloGiustiniani" target="_new" class="icon-github"></a><br />
				 Sviluppo GAIA e Supporto</li>

			<li><strong>Alfio Musmarra</strong> 
				<a href="https://github.com/alfiomusmarra" target="_new" class="icon-github"></a><br />
				 Supporto</li>

			<li><strong>Stefano Principato</strong> 
				<a href="https://facebook.com/stefano.principato.39" target="_new" class="icon-facebook-sign"></a><br />
				 Responsabile del Progetto</li>

			<li><strong>Flavio Ronzi</strong> 
				<a href="https://www.facebook.com/flavio.ronzi" target="_new" class="icon-facebook-sign"></a><br />
				 DTN Area VI e Coordinatore del Progetto</li>

			<li><strong>Biagio Saitta</strong> 
				<a href="https://facebook.com/biagiosaitta" target="_new" class="icon-facebook-sign"></a>
				<a href="https://github.com/biagiosaitta" target="_new" class="icon-github"></a><br />
				 Supporto ed Attivazione Comitati</li>

			<li><strong>Tommaso Scquizzato</strong> 
				<a href="https://facebook.com/tommaso.scquizzato" target="_new" class="icon-facebook-sign"></a><br />
				 Sviluppo app iOS</li>

			<li><strong>Giuseppe Titolo</strong> 
				<a href="https://facebook.com/mrgius" target="_new" class="icon-facebook-sign"></a>
				<a href="https://twitter.com/Giuseppe_Titolo" target="_new" class="icon-twitter"></a>
				<br />
				 Supporto ed Attivazione Comitati</li>

		</ul>

		<p>&nbsp;</p>
		<hr />

		<p><strong>Nota</strong>: Il testo &egrave; stato modificato dopo la pubblicazione iniziale.</p>

	</div>

	<div class="span5">

		<div class="row-fluid">
			<div class="span3">
				<div class="fb-like" data-href="https://gaia.cri.it/?p=comunicato" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>
			</div>
			<div class="span9">
				<a class="btn btn-large btn-block btn-primary" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fgaia.cri.it%2Findex.php%3Fp%3Dcomunicato" target="_new">
					<i class="icon-facebook-sign"></i>
					Condividi su Facebook
				</a>
			</div>
		</div>

		<hr />

		<div class="fb-comments" data-href="https://gaia.cri.it/?p=comunicato" data-width="470" data-numposts="25" data-colorscheme="light"></div>


	</div>
</div>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/it_IT/sdk.js#xfbml=1&appId=273577079445466&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
