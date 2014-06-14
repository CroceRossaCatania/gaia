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
			<p><strong>15 giugno 2014</strong></p>
			<h1>Nota della Squadra di Gaia</h1>
			<h4>Interruzione dello Sviluppo, del Supporto<br />e dell'assistenza per il progetto Gaia</h4>
		</div>

		<hr />

		<p>
		Ciao <?php echo (( $me instanceOf Volontario ) ? $me->nome : "Volontario"); ?>,<br/>
		come avrai potuto notare, in queste ultime settimane il portale che ospita il Progetto Gaia è poco responsivo e la squadra di Supporto non è più in grado di fornire assistenza con la stessa assiduità con cui lo faceva prima.
		</p>

		<h3>Cosa è successo?</h3>
		<p>
		Negli ultimi mesi un grandissimo numero di Comitati ha aderito al Progetto e di conseguenza il numero di volontari e soci registrati ha superato i <strong>56.000</strong>, facendo crescere drasticamente il carico di lavoro sull’infrastruttura informatica e rendendo <strong>improrogabile</strong> l’avvio di una serie di interventi e di migliorie per permettere al sistema di continuare a servire l’utenza.
		</p>

		<p>
		Purtroppo a questo incremento di utenti non è seguito <strong>l'adeguamento informatico necessario</strong> da parte della Croce Rossa per rendere disponibili a noi sviluppatori, e quindi a tutti gli utenti, le risorse che da ormai un anno stiamo chiedendo. 
		</p>

		<p>
		Nessuna delle numerose richieste che sono state avanzate per migliorare l’infrastruttura e gli strumenti tecnici necessari al Progetto si è concretizzata. Queste includevano ulteriori server, macchine più potenti, costi di licenze, strumenti di sviluppo. Noi sviluppatori siamo sempre stati abituati a lavorare in economia ed a sfruttare al meglio le risorse presenti, ma non e’ più pensabile che il Progetto possa servire tutta Italia con le stesse risorse con le quali è stati avviato.
		</p>

		<div id="grafico">
			<img src="/img/comunicato_img1.png" title="Grafico delle Pagine servite" alt="Grafico delle pagine servite" class="img-polaroid" />
			<br />
			<p>Grafico delle pagine servite per giorno dal Progetto, attuali 32mila/giorno</p>
		</div>

		<p>
		Alla data attuale, nonostante le decine di richieste e l’impegno costante che abbiamo messo nel Progetto, <strong>nessun investimento è stato fatto da parte della CRI su di esso</strong>. Purtroppo le procedure burocratiche a cui dobbiamo tutti sottostare hanno fatto fallire ogni tentativo iniziato dal gruppo di lavoro dell’Area VI e dagli sviluppatori di Gaia. Gli unici soldi spesi per rendere funzionante Gaia sono stati spesi direttamente dai volontari che ci hanno lavorato ininterrottamente e dal personale dell’area VI, di tasca propria, per evitare che tutto si fermasse.
		</p>

		<h3>Cosa ha fatto il team di Gaia?</h3>
		<p>
		Circa un mese fa, abbiamo comunicato all’Area VI la nostra <strong>impossibilità nel continuare a sostenere una situazione di questo tipo</strong>, indicando la fine di giugno come termine ultimo per concretizzare gli acquisti necessari, ormai improrogabili, oppure dare autorizzazione al Progetto di ricevere donazioni online per il suo stesso mantenimento o ancora permettere ad un Comitato CRI di sostenere i costi di Gaia per un periodo limitato in attesa che si trovasse il modo di risolvere la situazione. Tristemente, nonostante i costanti solleciti nel corso dei mesi, <strong>nessuna risposta</strong> &egrave; pervenuta alle nostre proposte avanzate.
		</p>

		<p>
		Crediamo fermamente che sia necessario essere seri e responsabili nei confronti degli utenti del
		sistema e che se si vuole servire un servizio questo deve essere erogato con standard di qualità
		accettabili, che siano al passo coi tempi sia per quanto riguarda gli aspetti tecnici sia per quanto
		riguarda la tipologia di servizio fornito. Preferiamo, per rispetto nei confronti di tutti gli utenti
		nel caso non sia possibile lavorare in queste condizioni, non erogare nessun servizio.	
		</p>

		<h3>Cosa succederà ora?</h3>
		<p>
		Alla fine di questo mese, nel caso in cui nulla cambierà, non svilupperemo più nuove funzionalità, non rilasceremo aggiornamenti al sistema e non saremo più in grado di dare seguito alle richieste di assistenza che arriveranno tramite i canali di supporto.
		</p>

		<h3>Cosa devo fare?</h3>
		<p>
		Se sei un presidente o un delegato ufficio soci, ti invitiamo a scaricare e conservare gli elenchi dei volontari e dei soci ordinari che hai caricato su Gaia, dalle apposite sezioni, di modo da non perdere i dati.
		</p>

		<h3>Nuove funzionalità che non vedranno la luce</h3>
		<p>
		Moltissime funzionalità di Gaia in questi mesi sono state sviluppate partendo dai regolamenti e dalle esigenze dei comitati CRI. Alcune di queste, ormai pronte per essere rilasciate, non verranno messe a disposizione in quanto non potranno essere adeguatamente mantenute.</p>
		<p>
		Le funzionalità sviluppate e non presenti sul sistema sono le seguenti:
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
		</ul>
		</p>

		<p>
		Oltre a quanto riportato in elenco è in fase di completamento l'applicazione per smartphone iOS. Anche questo ulteriore strumento purtroppo non
		vedr&agrave; la luce.
		</p>

		<p>
		<strong>E tanto altro ancora...</strong><br/>
		Tante sono poi le funzionalità di Gaia in fase di sviluppo, a cominciare dal sistema di gestione
		unificato per la formazione interna ed esterna all'associazione, passando per il modulo di 
		gestione delle visite mediche e degli aspetti sanitari che avrebbe integrato tutte le procedure
		di sicurezza per la gestione dei dati sensibili, arrivando al modulo per la gestione di vestiario
		e magazzini interni al comitato e tanto altro ancora.
		</p>

		<h3>Ringraziamenti</h3>
		<p>
		Vorremmo ringrazia tutti gli utenti di Gaia che in questi mesi hanno contribuito a segnalarci 
		bug e malfunzionamenti di ogni genere via email, telefono, github, facebook e con ogni altro 
		strumento. Vorremmo inoltre ringraziare tutte le persone che ci hanno suggerito funzionalità e 
		miglioramenti da introdurre nel sistema. Vorremmo ringraziare inoltre tutti i presidenti e gli 
		uffici soci dei comitati che hanno aderito al progetto e hanno avuto la pazienza di attendere le 
		risposte del supporto quando avevano qualche problema, di compilare in maniera corretta gli i 
		formati e di spiegare ai loro volontari come utilizzare il sistema. Da ultimo ci teniamo a ringraziare 
		tutto lo staff dell'helpdesk di primo livello che in questi mesi ci ha aiutato a smaltire il 
		numero sempre maggiore di ticket da parte degli utenti.
		</p>

		<blockquote style="font-weight: bold;">
		La nostra speranza è quella che la Croce Rossa Italiana decida, visto l'entusiasmo dei Volontari che hanno creduto nel progetto e gli ottimi risultati raggiunti in poco tempo e con un budget nullo, di investire e far crescere questo progetto anche se, al momento attuale, la strada sembra essere troppo in salita anche per noi.
		</blockquote>

		<p>&nbsp;</p>

		<p style="font-style: italic;">
		In fede,<br />
		Gli Sviluppatori e la Squadra di Supporto di Gaia:
		</p>

		<ul id="sviluppatori">
			<li><strong>Alberto Copelli</strong>
				<a href="#" target="_new" class="icon-github"></a><br />
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
				<a href="#" target="_new" class="icon-github"></a><br />
				 Sviluppo GAIA e Supporto</li>

			<li><strong>Alfio Musmarra</strong> 
				<a href="#" target="_new" class="icon-facebook-sign"></a><br />
				 Supporto</li>

			<li><strong>Stefano Principato</strong> 
				<a href="#" target="_new" class="icon-facebook-sign"></a><br />
				 Responsabile progetto</li>

			<li><strong>Biagio Saitta</strong> 
				<a href="#" target="_new" class="icon-github"></a><br />
				 Supporto ed Attivazione Comitati</li>

			<li><strong>Tommaso Scquizzato</strong> 
				<a href="#" target="_new" class="icon-github"></a><br />
				 Sviluppo app iOS</li>

			<li><strong>Giuseppe Titolo</strong> 
				<a href="https://facebook.com/mrgius" target="_new" class="icon-facebook-sign"></a>
				<a href="https://twitter.com/Giuseppe_Titolo" target="_new" class="icon-twitter"></a>
				<br />
				 Supporto ed Attivazione Comitati</li>

		</ul>

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
