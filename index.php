<?php

/*
 * ©2013 Croce Rossa Italiana
 */

/* Modalità manutenzione */
if (file_exists('upload/setup/manutenzione')) {
    header('HTTP/1.1 307 Temporary Redirect');
    header('Location: docs/manutenzione.html');
    exit(0);
}

$_stopwatch = microtime(true);

require('./core.inc.php');
    
/* Attiva il caching */
ob_start('ob_gzhandler');
ob_start('impostaTitoloDescrizione');

/* Sessione utente via cookie */
if ( isset($_COOKIE['sessione']) ) {
    $sid = $_COOKIE['sessione'];
} else {
    $sid = null;
}
$sessione = new Sessione($sid);
@setcookie('sessione', $sessione->id, time() + $conf['sessioni']['durata']);
 
/* Crea eventuale oggetto $me */
$me = $sessione->utente();

/* Aggiorna la sessione con i miei dati... */
$sessione->ip       = $_SERVER['REMOTE_ADDR'];
$sessione->agent    = $_SERVER['HTTP_USER_AGENT'];

/* Flag dei selettori */
$_carica_selettore              = false;
$_carica_selettore_comitato     = false;

/* Pagina da visualizzare */
$p = $_GET['p'];
if (!$p) { $p = 'home'; }
$_f = "./inc/$p.php";
if ( !file_exists($_f) ) {
	$_f = "./inc/errore.404.php";
}

/*
 * Titolo e descrizione se non ridefiniti
 */
$_titolo        = 'Progetto Gaia - Croce Rossa Italiana';
$_descrizione   = 'Crediamo in una Croce Rossa Italiana che sa muoversi velocemente, più trasparente ed aperta a tutti';

?><!DOCTYPE html>
<html>
  <head>
  	<meta charset="utf-8" />
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>{_titolo}</title>
    <meta name="description" content="{_descrizione}">
    <meta name="author" content="Progetto Gaia - Croce Rossa Italiana">
    <link rel="shortcut icon" href="/img/favicon.ico" />

    <!-- CSS -->
    <link href="css/bootstrap.min.css"      rel="stylesheet" media="screen">
    <link href="css/font-awesome.min.css"   rel="stylesheet" media="screen">
    <link href="css/main.css"               rel="stylesheet" media="screen">
    <link href="css/fullcalendar.css"       rel="stylesheet" media="screen">
    <link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-lightness/jquery-ui.min.css" rel="stylesheet" media="screen">
    <!--[if IE]>
        <link href="css/main-ie.css" rel="stylesheet" media="screen">
    <![endif]-->
    <!--[if IE 7]>
      <link rel="stylesheet" href="css/font-awesome-ie7.min.css">
    <![endif]-->

    <!-- JS -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"        ></script>
    <script type="text/javascript" src="js/modernizr.custom.03290.js"                   ></script>
    <script type="text/javascript" src="js/bootstrap.min.js"                            ></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"   ></script>
    <script type="text/javascript" src="js/jquery.timepicker.js"                        ></script>
    <script type="text/javascript" src="js/fullcalendar.min.js"                         ></script>
    <script type="text/javascript" src="js/jquery.cookie.js"                            ></script>
    <script type="text/javascript" src="js/app.js"                                      ></script>
    <script type="text/javascript" src="js/ui.datepicker-it.js"                         ></script>
    <script type="text/javascript" src="js/tinymce/tinymce.min.js"                      ></script>
    <script type="text/javascript" src="js/polychart2.standalone.js"                    ></script>
    <?php if (file_exists('js/'. $p . '.js')) { /* Javascript dinamico */ ?>
        <script type="text/javascript" src="js/<?php echo $p; ?>.js"></script>
    <?php } ?>

  </head>
  <body>
    <div class="navbar-wrapper">
      <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <a class="brand" href="?">
            	<img src="./img/logoTop.png" />
            	&nbsp; <span class="muted">Croce Rossa Italiana</span> &nbsp; «Gaia»
            </a>
            <div class="nav-collapse collapse">
              <ul class="nav">
                <li><a href="index.php"><i class="icon-home"></i> Home</a></li>
                <li><a href="?p=attivita"><i class="icon-calendar"></i> Attività</a></li>
                <li><a href="?p=public.comitati.mappa"><i class="icon-map-marker"></i> Comitati</a></li>
              </ul>  
            <?php
            if ( $me ) { 
            ?>
			<div class="pull-right paddingSopra">
			  
                          <div class="btn-group">
                            <a class="btn btn-danger" href="?p=utente.me">
                                  <i class="icon-user icon-large"></i>&nbsp;
                                  Ciao, <strong><?php echo $me->nome; ?></strong></a>
                            <button class="btn dropdown-toggle btn-danger" data-toggle="dropdown">
                                  <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php if ( $me->stato == VOLONTARIO ) { ?>
                                  <li><a href="?p=utente.anagrafica"><i class="icon-edit"></i> Anagrafica</a></li>
                                  <li><a href="?p=utente.privacy"><i class="icon-cog"></i> Privacy</a></li>
                                  <li class="divider"></li>
                                <?php } ?>

                                  <li><a href="?p=logout"><i class="icon-remove"></i> Esci</a></li>
                            </ul>
                          </div>
                            
                            
                            <?php if ( $me->admin() || $me->presiede() ) { ?>
                            <div class="btn-group">
                                <?php
                                    /* Conto le notifiche */
                                    $_n     =   $_n_titoli = $_n_app = $_n_trasf = $_n_ris = $_n_est = 0;
                                    $_n     +=  $_n_titoli = $me->numTitoliPending  ([APP_PRESIDENTE, APP_SOCI]);
                                    $_n     +=  $_n_app    = $me->numAppPending     ([APP_PRESIDENTE, APP_SOCI]);
                                    $_n     +=  $_n_trasf  = $me->numTrasfPending   ([APP_PRESIDENTE]);
                                    $_n     +=  $_n_ris    = $me->numRisPending     ([APP_PRESIDENTE, APP_SOCI]);
                                    $_n     +=  $_n_est    = $me->numEstPending     ([APP_PRESIDENTE]);
                                   ?>
                                <button class="btn dropdown-toggle btn-inverse" data-toggle="dropdown">
                                    <i class="icon-asterisk"></i>
                                    <strong>Presidente</strong>
                                    <?php if ( $_n ) { ?>
                                        <span class="badge badge-warning">
                                            <?php echo $_n; ?>
                                        </span>
                                    <?php } ?>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                   
                                    <li class="nav-header">Da fare</li>
                                    
                                    <li>
                                        <a href="?p=presidente.titoli">
                                            <i class="icon-star"></i>
                                            Titoli in attesa
                                            <?php if ( $_n_titoli ) { ?>
                                                <span class="badge badge-warning">
                                                    <?php echo $_n_titoli; ?>
                                                </span>
                                            <?php } ?>
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="?p=presidente.appartenenzepending">
                                            <i class="icon-group"></i>
                                            Appartenenze in attesa
                                            <?php if ( $_n_app ) { ?>
                                                <span class="badge badge-warning">
                                                    <?php echo $_n_app; ?>
                                                </span>
                                            <?php } ?>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="?p=presidente.estensione">
                                            <i class="icon-random"></i>
                                            Estensioni in attesa
                                            <?php if ( $_n_est ) { ?>
                                                <span class="badge badge-warning">
                                                    <?php echo $_n_est; ?>
                                                </span>
                                            <?php } ?>
                                        </a>
                                    </li>
                                    

                                    <li>
                                        <a href="?p=presidente.trasferimento">
                                            <i class="icon-arrow-right"></i>
                                            Trasferimenti in attesa
                                            <?php if ( $_n_trasf ) { ?>
                                                <span class="badge badge-warning">
                                                    <?php echo $_n_trasf; ?>
                                                </span>
                                            <?php } ?>
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="?p=presidente.riserva">
                                            <i class="icon-pause"></i>
                                            Riserve in attesa
                                            <?php if ( $_n_ris ) { ?>
                                                <span class="badge badge-warning">
                                                    <?php echo $_n_ris; ?>
                                                </span>
                                            <?php } ?>
                                        </a>
                                    </li>
                                    
                                    <li class="nav-header">Volontari</li>
                                
                                    <li>
                                        <a href="?p=presidente.utenti">
                                            <i class="icon-list"></i>
                                            Elenco volontari
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?p=presidente.supervisione">
                                            <i class="icon-eye-close"></i>
                                            Supervisione
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?p=presidente.titoli.ricerca">
                                            <i class="icon-search"></i>
                                            Ricerca volontari per titoli
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <?php } ?>

            
                            <?php if ( $me->admin() ) { ?>
                            <div class="btn-group">
                                <button class="btn dropdown-toggle btn-inverse" data-toggle="dropdown">
                                    <i class="icon-wrench icon-large"></i>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="?p=admin.presidenti"><i class="icon-list"></i> Presidenti</a></li>
                                    <li><a href="?p=admin.delegati"><i class="icon-list"></i> Delegati</a></li>
                                    <li><a href="?p=admin.admin"><i class="icon-star"></i> Amministratori</a></li>
                                    <li><a href="?p=admin.comitati"><i class="icon-bookmark"></i> Comitati</a></li>
                                    <li><a href="?p=admin.reset.comitati"><i class="icon-fire"></i> Reset Comitati</a></li> 
                                    <li><a href="?p=admin.tesseramento"><i class="icon-eur"></i> Tesseramento</a></li>
                                    <li><a href="?p=admin.titoli"><i class="icon-certificate"></i> Titoli</a></li>
                                    <li><a href="?p=admin.ricerca"><i class="icon-search"></i> Cerca Utente</a></li> 
                                    <li><a href="?p=admin.limbo"><i class="icon-meh"></i> Limbo</a></li> 
                                    <li><a href="?p=admin.double"><i class="icon-superscript"></i> Double</a></li>
                                    <li><a href="?p=admin.script"><i class="icon-stackexchange"></i> Script</a></li>
                                    <li><a href="?p=admin.report"><i class="icon-copy"></i> Report</a></li>  
                                    <li><a href="?p=admin.format"><i class="icon-upload"></i> Carica format</a></li>                                    
                                    <li><a href="?p=admin.cache"><i class="icon-cloud"></i> Cache</a></li>  
                                    <li><a href="?p=admin.chiavi"><i class="icon-code"></i> API Keys</a></li>  
                                    <li><a href="?p=admin.buttafuori" data-conferma="Resettare tutte le sessioni?"><i class="icon-signout"></i> Butta fuori</a></li>  
                                </ul>
                            </div>
                            <?php } ?>

                            <?php if ( $me->admin && !$me->admin() ) { ?>
                            <!-- ADMIN MODE NON ATTIVATA... -->
                                <a href="#adminMode" class="btn btn-inverse" data-toggle="modal" role="button">
                                    <i class="icon-github-alt icon-large"></i>
                                </a>


                            <?php } ?>

                                           
			</div>
			<?php } else { ?>
            <div class="paddingSopra pull-right">
            	<a class="btn btn-danger" href="?p=login">
            		<strong>Accedi</strong>
            		<i class="icon-key"></i>
            	</a>
            </div>
            <?php } ?>
            </div>
          </div>
        </div>
    </div>
    </div>

    <?php if ( in_array($p, $conf['slide'] ) ) { ?>
    <div id="caroselloHome" class="carousel slide">
      <div class="carousel-inner">
        <!--<div class="item active">
          <img src="./img/jump.png" alt="">
          <div class="container">
            <div class="carousel-caption">
                <br/><br/>
              <p class="lead">
                  <div class="btn-group">
                      <a href="http://cri.it/bologna2013" class="btn btn-large btn-info">
                          <i class="icon-info"></i> Maggiori informazioni
                      </a>
                      <a href="http://crocerossa.eventbrite.it/" class="btn btn-large btn-warning">
                          <i class="icon-thumbs-up"></i> Iscriviti online
                      </a>
                  </div>
                </p>
            </div>
          </div>
        </div>-->
        <div class="item active">
          <img src="./img/foto4.jpg" alt="">
          <div class="container">
            <div class="carousel-caption">
              <h1>Reinventiamo Croce Rossa</h1>
              <p class="lead">Facciamola nuova, più efficiente e trasparente</p>
              <!--<p class="lead">
		    	     <i class="icon-lightbulb icon-large"></i> Prendi posto
			        </p>-->
            </div>
          </div>
        </div>
        <div class="item">
          <img src="./img/foto5.jpg" alt="">
          <div class="container">
            <div class="carousel-caption">
              <h1>Persone in Prima Persona</h1>
              <p class="lead">Grazie al nuovo obiettivo trasparenza, vedi cosa sta facendo Croce Rossa attorno a te</p>
              <p class="lead">
              <div class="btn-group">
                  <a href="?p=public.attivita.mappa" class="btn btn-large btn-info">
                      <i class="icon-globe"></i> Mappa delle attività
                  </a>
                  <a href="?p=public.comitati.mappa" class="btn btn-large btn-primary">
                      <i class="icon-map-marker"></i> Mappa delle Sedi CRI
                  </a>
              </div>
            </p>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="./img/foto3.jpg" alt="">
          <div class="container">
            <div class="carousel-caption">
              <h1>Prendi parte alla rivoluzione</h1>
              <p class="lead">diventando un volontario di Croce Rossa. È semplice.</p>
              <a class="btn btn-large btn-warning" href="?p=riconoscimento&tipo=aspirante">Informati per il prossimo corso base</a>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#caroselloHome" data-slide="prev">&lsaquo;</a>
      <a class="right carousel-control" href="#caroselloHome" data-slide="next">&rsaquo;</a>
    </div><!-- /.carousel -->
    <?php } else { ?>
    <div id="caroselloHome" class="carousel slide">
      <div class="carousel-inner">
        <div class="item active altoCento">
          <img class="altoCento" src="./img/noSlide_cri.png" alt="">
          <div class="container">
          </div>
        </div>
      </div>
    </div><!-- /.carousel -->
    <?php } ?>
    
    <div class="container">

<?php

	/* Qui si include la pagina */
	require($_f);
	
?>
      <hr />

      <div class="footer row-fluid">
                    <div class="span6">
                        <p><span class="muted">Progetto Gaia</span> <br />
                            &copy;2014 <strong>Croce Rossa Italiana</strong>
                        </p>
                    </div>
      	<div class="span6 allinea-destra">
	        <a href="/">Torna alla home</a> &middot;
	        <a href="?p=public.about">Informazioni su Gaia</a> &middot;
	        <a href="docs/Guida.pdf?ref=footer"><strong>Guida in PDF</strong></a> &middot;
	        <?php if($me){ ?><a href="?p=utente.supporto"><?php }else{?><a href="mailto:supporto@gaia.cri.it"><?php } ?>Supporto</a><br />
	        Croce Rossa. <strong>Persone in prima persona.</strong>
   		  </div>
      </div>

    </div> <!-- /container -->
    
    <?php if ( $_carica_selettore ) {
        include './inc/part/utente.selettore.php';
    } ?>
    
    <?php if ( $_carica_selettore_comitato ) {
        include './inc/part/comitato.selettore.php';
    } ?>

    <?php if ( $me->admin && !$me->admin() ) { ?>
    <!-- ADMIN MODE NON ATTIVATA -->
      <div id="adminMode" class="modal hide fade" role="dialog">
        <div class="modal-header">
          <h3>
            <i class="icon-github-alt icon-large"></i>
            Stai per entrare nella Admin Mode
          </h3>
        </div>
        <div class="modal-body">
          <p>Entrando nella modalità amministratore entrerai in contatto con una grande mole
             di dati sensibili di persone che ti hanno indirettamente dato la loro fiducia.</p>
          <p>
             &mdash;
              <strong class="text-success">
                Per questo ti chiediamo di rinnovare la tua promessa.
              </strong>
          </p>
          <h4 class="text-error">Tieni in mente tre cose</h4>
          <ol>
            <li>Rispetta la privacy degli altri;</li>
            <li>Pensa sempre prima di scrivere e cliccare;</li>
            <li><em>Da grandi poteri derivano grandi responsabilità</em>.</li>
          </ol>
          <p class="text-info">
            <i class="icon-time"></i>
            Rimarrai in modalità admin fino al Logout
          </p>

        </div>
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn">Annulla</a>
          <a href="?p=admin.mode" class="btn btn-danger">
            <i class="icon-ok"></i>
            Okay, lo prometto
          </a>
        </div>
      </div>
      <?php } ?>
    
    <!-- Statistiche -->
	<script type="text/javascript">
	  var _paq = _paq || [];
	  _paq.push(["trackPageView"]);
	  _paq.push(["enableLinkTracking"]);
	  (function() {
	    var u = "https://stats.gaiacri.it/";
	    _paq.push(["setTrackerUrl", u+"piwik.php"]);
	    _paq.push(["setSiteId", "1"]);
	    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
	    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
	  })();
	</script>
    <!-- Fine codice statistiche -->

    <!-- DEBUG. Q: <?php echo $db->numQuery; ?>; M: <?php echo ceil(memory_get_peak_usage()/1024); ?> kB; T: <?php echo round(microtime(true)-$_stopwatch, 6); ?>s -->
    <!-- FUSION TAG --><div class="hidden-phone" id="swifttagcontainerf62rpdvx6p"><div id="proactivechatcontainerf62rpdvx6p"></div><div style="display: inline;" id="swifttagdatacontainerf62rpdvx6p"></div></div> <script type="text/javascript">var swiftscriptelemf62rpdvx6p=document.createElement("script");swiftscriptelemf62rpdvx6p.type="text/javascript";var swiftrandom = Math.floor(Math.random()*1001); var swiftuniqueid = "f62rpdvx6p"; var swifttagurlf62rpdvx6p="https://supporto.giovanicri.it/visitor/index.php?/Default/LiveChat/HTML/SiteBadge/cHJvbXB0dHlwZT1jaGF0JnVuaXF1ZWlkPWY2MnJwZHZ4NnAmdmVyc2lvbj00LjU4LjAuMzY1MCZwcm9kdWN0PUZ1c2lvbiZmaWx0ZXJkZXBhcnRtZW50aWQ9NTAmcm91dGVjaGF0c2tpbGxpZD00JnNpdGViYWRnZWNvbG9yPXdoaXRlJmJhZGdlbGFuZ3VhZ2U9ZW4mYmFkZ2V0ZXh0PWxpdmVjaGF0Jm9ubGluZWNvbG9yPSMxZGI1MWQmb25saW5lY29sb3Job3Zlcj0jNjFjYzYxJm9ubGluZWNvbG9yYm9yZGVyPSMxNDdmMTQmb2ZmbGluZWNvbG9yPSNmZjAwMDAmb2ZmbGluZWNvbG9yaG92ZXI9I2ZmNGQ0ZCZvZmZsaW5lY29sb3Jib3JkZXI9I2IzMDAwMCZhd2F5Y29sb3I9I2I4YjhiOCZhd2F5Y29sb3Job3Zlcj0jY2VjZWNlJmF3YXljb2xvcmJvcmRlcj0jODE4MTgxJmJhY2tzaG9ydGx5Y29sb3I9I2UwOTMyMCZiYWNrc2hvcnRseWNvbG9yaG92ZXI9I2VhYjQ2MyZiYWNrc2hvcnRseWNvbG9yYm9yZGVyPSM5ZDY3MTYmY3VzdG9tb25saW5lPSZjdXN0b21vZmZsaW5lPSZjdXN0b21hd2F5PSZjdXN0b21iYWNrc2hvcnRseT0KYjlkYzdkNmE0NGUyNTBlMWE1ZDhlOWJmYzdlOTM2ZmJiYjdlMTU3ZQ==";setTimeout("swiftscriptelemf62rpdvx6p.src=swifttagurlf62rpdvx6p;document.getElementById('swifttagcontainerf62rpdvx6p').appendChild(swiftscriptelemf62rpdvx6p);",1);</script><!-- END FUSION TAG CODE - DO NOT EDIT! -->
    <!-- FUSION TAG --><div class="hidden-phone" id="proactivechatcontainerafechw6ctt"></div><div id="swifttagcontainerafechw6ctt" style="display: none;"><div id="swifttagdatacontainerafechw6ctt"></div></div> <script type="text/javascript">var swiftscriptelemafechw6ctt=document.createElement("script");swiftscriptelemafechw6ctt.type="text/javascript";var swiftrandom = Math.floor(Math.random()*1001); var swiftuniqueid = "afechw6ctt"; var swifttagurlafechw6ctt="https://supporto.giovanicri.it/visitor/index.php?/LiveChat/HTML/Monitoring/cHJvbXB0dHlwZT1jaGF0JnVuaXF1ZWlkPWFmZWNodzZjdHQmdmVyc2lvbj00LjU4LjAuMzY1MCZwcm9kdWN0PUZ1c2lvbiZjdXN0b21vbmxpbmU9JmN1c3RvbW9mZmxpbmU9JmN1c3RvbWF3YXk9JmN1c3RvbWJhY2tzaG9ydGx5PQo0ODFmZjE5NjZhOTY3ZDVhNzY0OTZkMmQ1MTdmMmEyZTU4NGQ4OGE0";setTimeout("swiftscriptelemafechw6ctt.src=swifttagurlafechw6ctt;document.getElementById('swifttagcontainerafechw6ctt').appendChild(swiftscriptelemafechw6ctt);",1);</script><!-- END FUSION TAG CODE - DO NOT EDIT! -->
  
  </body>
</html><?php
ob_end_flush(); 
header("Content-length: " . ob_get_length()); 
ob_end_flush();
