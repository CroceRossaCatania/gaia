<?php

/*
 * ©2014 Croce Rossa Italiana
 */

/* Modalità manutenzione */
if (file_exists('upload/setup/manutenzione')) {
    header('HTTP/1.1 307 Temporary Redirect');
    header('Location: docs/manutenzione.html');
    exit(0);
}

$_stopwatch = microtime(true);

require('./core.inc.php');

/* Attiva la gestione degli errori */
set_error_handler('gestore_errori');

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

/* Registra dati transazione */
if ( $me->admin ) {
    ignoraTransazione();
} else {
    $identificato = (bool) ($me && $me->id);
    registraParametroTransazione('login', (int) $identificato);
    if ( $identificato )
        registraParametroTransazione('uid', $me->id);
}

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
nomeTransazione($p, 'web');

/*
 * Titolo e descrizione se non ridefiniti
 */
$_titolo        = 'Progetto Gaia - Croce Rossa Italiana';
$_descrizione   = 'Crediamo in una Croce Rossa Italiana che sa muoversi velocemente, più trasparente ed aperta a tutti';

?><!DOCTYPE html>
<html>
  <head prefix="og: http://ogp.me/ns#">
  	<meta charset="utf-8" />
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>{_titolo}</title>
    <meta property="og:url" content="http://gaia.cri.it/?p=<?= $p ?>">
    <meta property="og:title" content="{_titolo}">
    <meta property="og:site_name" content="Progetto Gaia - Croce Rossa Italiana">
    <meta property="og:description" content="{_descrizione}">
    <meta property="og:image" content="http://gaia.cri.it/img/Emblema_CRI.png"/>
    <meta name="description" content="{_descrizione}">
    <meta name="author" content="Progetto Gaia - Croce Rossa Italiana">
    <link rel="shortcut icon" href="/img/favicon.ico" />

    <!-- JS e CSS compressi -->
    <link href="/assets/min/20151005/build/build.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="/assets/min/20151005/build/build.js"></script>

    <!-- Recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js?hl=it" async defer></script>

	<!-- Font -->
    <link href='https://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>
    
	<!--[if IE]>
        <link href="css/main-ie.css" rel="stylesheet" media="screen">
    <![endif]-->
    <!--[if IE 7]>
      <link rel="stylesheet" href="css/font-awesome-ie7.min.css">
    <![endif]-->

    <!-- JS -->
    <?php if (file_exists('assets/js/'. $p . '.js')) { /* Javascript dinamico */ ?>
        <script type="text/javascript" src="/assets/js/<?php echo $p; ?>.js"></script>
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
                        <img src="./img/logoCroceSemplice.png" />
                        &nbsp;<span class="scritta-cri">Croce Rossa Italiana</span><span class="hidden-phone scritta-gaia">&nbsp;|&nbsp;Gaia</span>
                    </a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li><a href="index.php"><i class="icon-home"></i> Home</a></li>
                            <li><a href="?p=attivita"><i class="icon-calendar"></i> Attività</a></li>
                            <li><a href="?p=public.comitati.mappa"><i class="icon-map-marker"></i> Comitati</a></li>
                            <li><a href="?p=public.formazione"><i class="icon-desktop"></i> Formazione</a></li>
							<?php if(!$me) { ?>
                            <li><a href="?p=public.tesserino"><i class="icon-credit-card"></i> Verifica tesserino</a></li>
                            <?php } ?>
                        </ul>  
                        <?php
                        if ( $me ) { 
                            $admin = $me->admin(); ?>
                            <div class="pull-right paddingSopra">

                                <div class="btn-group">
                                    <a class="btn btn-danger" href="?p=utente.me">
                                        <i class="<?php if ($admin) { ?> icon-github-alt <?php } else{ ?> icon-user <?php } ?> icon-large"></i>&nbsp;
                                        Ciao <strong><?php echo $me->nome; ?></strong></a>
                                        <button class="btn dropdown-toggle btn-danger" data-toggle="dropdown">
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <?php if ( $me->stato == VOLONTARIO ) { ?>
                                            <li><a href="?p=utente.privacy"><i class="icon-cog"></i> Privacy</a></li>
                                            <?php } ?>

                                            <li><a href="?p=utente.contatti"><i class="icon-phone"></i> Modifica contatti</a></li>
                                            <li><a href="?p=utente.password"><i class="icon-key"></i> Modifica password</a></li>
                                            <?php if ( $me->stato == ASPIRANTE && !$me->partecipazioniBase(ISCR_CONFERMATA)) { ?>
                                            <li><a href="?p=aspirante.cancellati"><i class="icon-remove-sign"></i> Cancellati</a></li>
                                            <?php } ?>
                                            <li class="divider"></li>
                                            <li><a href="?p=logout"><i class="icon-remove"></i> Esci</a></li>
                                            <?php if ( $me->admin && $me->admin() ) { ?>
                                                <!-- ADMIN MODE  ATTIVATA... -->
                                                <li><a href="?p=admin.mode.exit"><i class="icon-thumbs-down-alt "></i> Torna quello di una volta</a></i>
                                                </a>
                                            <?php } ?>
                                            <?php if ( $me->supporto && $me->supporto() ) { ?>
                                                <!-- ADMIN MODE  ATTIVATA... -->
                                                <li><a href="?p=support.mode.exit"><i class="icon-thumbs-down-alt "></i> Torna quello di una volta</a></i>
                                                </a>
                                            <?php } ?>
                                        </ul>
                                    </div>


                                    <?php 
                                    if ( $me->admin() || $me->presiede() ) { ?>
                                    <div class="btn-group">
                                        <?php
                                        /* Conto le notifiche */
                                        $_n     =   $_n_titoli 		= $_n_app = $_n_trasf = $_n_ris = $_n_est = 0;
                                        $_n     +=  $_n_titoli 		= (!$admin) ? $me->numTitoliPending  ([APP_PRESIDENTE, APP_SOCI]) : 0;
										$_n     +=  $_n_donazioni 	= (!$admin) ? $me->numDonazioniPending	([APP_PRESIDENTE, APP_SOCI]) : 0;
                                        $_n     +=  $_n_app    		= (!$admin) ?$me->numAppPending     ([APP_PRESIDENTE, APP_SOCI]) : 0;
                                        $_n     +=  $_n_trasf  		= (!$admin) ?$me->numTrasfPending   ([APP_PRESIDENTE]) : 0;
                                        $_n     +=  $_n_ris    		= (!$admin) ?$me->numRisPending     ([APP_PRESIDENTE, APP_SOCI]) : 0;
                                        $_n     +=  $_n_est    		= (!$admin) ?$me->numEstPending     ([APP_PRESIDENTE]) : 0;
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
												<a href="?p=presidente.donazioni">
													<i class="icon-star"></i>
													Donazioni in attesa
													<?php if ( $_n_donazioni ) { ?>
													<span class="badge badge-warning">
														<?php echo $_n_donazioni; ?>
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
                                            <li class="nav-header">Elenchi</li>
                                            <li><a href="?p=admin.ricerca.utenti"><i class="icon-search"></i> Cerca Utente</a></li> 
                                            <li><a href="?p=admin.ricerca.attivita"><i class="icon-calendar"></i> Cerca Attività</a></li> 
                                            <li><a href="?p=admin.presidenti"><i class="icon-list"></i> Presidenti</a></li>
                                            <li><a href="?p=admin.delegati"><i class="icon-list"></i> Delegati</a></li>
                                            <li><a href="?p=admin.admin"><i class="icon-star"></i> Amministratori</a></li>
                                            <li><a href="?p=admin.comitati"><i class="icon-bookmark"></i> Comitati</a></li> 
                                            <li><a href="?p=admin.titoli"><i class="icon-certificate"></i> Titoli</a></li>
											<li><a href="?p=admin.donazioni"><i class="icon-beaker"></i> Donazioni</a></li>
											<li><a href="?p=admin.donazioni.sedi"><i class="icon-road"></i> Donazioni sedi</a></li>
                                            <li><a href="?p=admin.limbo"><i class="icon-meh"></i> Limbo</a></li> 
                                            <li><a href="?p=admin.aspiranti"><i class="icon-meh"></i> Aspiranti</a></li> 
                                            <li><a href="?p=admin.double"><i class="icon-superscript"></i> Double</a></li>
                                            <li><a href="?p=admin.tesseramento"><i class="icon-eur"></i> Tesseramento</a></li>
                                            <li class="nav-header">Report & Co</li>
                                            <li><a href="?p=admin.report"><i class="icon-copy"></i> Report</a></li>  
                                            <li><a href="?p=admin.stats"><i class="icon-copy"></i> Statistiche</a></li>
                                            <li><a href="?p=admin.report.comitati.excel"><i class="icon-building"></i> Excel Comitati</a></li>  
                                            <li><a href="?p=admin.format"><i class="icon-upload"></i> Format</a></li> 
                                            <li class="nav-header">Avanzate</li>
                                            <li><a href="?p=admin.buttafuori" data-conferma="Butti fuori tutti da Gaia?"><i class="icon-frown"></i> Butta fuori</a></li> 
                                            <li><a href="?p=admin.script"><i class="icon-stackexchange"></i> Script</a></li> 
                                            <li><a href="?p=admin.reset.comitati"><i class="icon-fire"></i> Reset Comitati</a></li>
                                            <li><a href="?p=admin.cache"><i class="icon-cloud"></i> Cache</a></li>
                                            <li><a href="?p=admin.mongodb"><i class="icon-heart"></i> Mongo</a></li>  
                                            <li><a href="?p=admin.chiavi"><i class="icon-code"></i> API Keys</a></li>
                                            <li><a href="?p=admin.errori"><i class="icon-bug"></i> Bugs</a></li>    
                                        </ul>
                                    </div>
                                    <?php } ?>
                                    
                                    
                                     <?php if ( $me->supporto() ) { ?>
                                    <div class="btn-group">
                                        <button class="btn dropdown-toggle btn-inverse" data-toggle="dropdown">
                                            <i class="icon-wrench icon-large"></i>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li class="nav-header">Elenchi</li>
                                            <li><a href="?p=supporto.ricerca.utenti"><i class="icon-search"></i> Cerca Utente</a></li> 
                                            <li><a href="?p=supporto.titoli"><i class="icon-certificate"></i> Titoli</a></li>
                                        </ul>
                                    </div>
                                    <?php } ?>

                                    <?php if ( $me->admin && !$me->admin() ) { ?>
                                    <!-- ADMIN MODE NON ATTIVATA... -->
                                    <a href="#adminMode" class="btn btn-inverse" data-toggle="modal" role="button">
                                        <i class="icon-github-alt icon-large"></i>
                                    </a>
                                    <?php } ?> 
                                    <?php if ( $me->supporto && !$me->supporto() ) { ?>
                                    <!-- SUPPORT MODE NON ATTIVATA... -->
                                    <a href="#supportMode" class="btn btn-inverse" data-toggle="modal" role="button">
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

            <?php  if ( $p == 'home' ) { ?>
            <div id="caroselloHome" class="carousel slide">
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="./img/foto4.jpg" alt="">
                        <div class="container">
                            <div class="carousel-caption">
                                <h1>Reinventiamo Croce Rossa</h1>
                                <p class="lead">Facciamola nuova, più efficiente e trasparente</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <img src="./img/foto6.png" alt="">
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

            <div id="normativaEU" class="container" style="display: none;">
                <div class="alert alert-info">
                    <button id="nascondiNormativaEU" type="button" class="close" data-dismiss="alert">Nascondi &times;</button>
                    <i class="icon-info-sign"></i> 
                    <strong>Gaia utilizza i <i>cookies</i> per offrirti le sue funzionalit&agrave; e per scopi statistici.</strong><br />
                    Continuando a navigare su gaia.cri.it, acconsenti all'uso dei cookie su questo sito web.<br />
                    <a href="?p=public.cookie" target="_new">
                        Clicca qui per le informazioni sull'uso dei Cookie in Gaia
                    </a> oppure 
                    <a href="?p=public.privacy" target="_new">
                        clicca qui per leggere l'informativa sulla Privacy.
                    </a>
                </div>
            </div>

            <div class="container<?= ( $p == 'home' ) ? '-fluid' : ''; ?> ">

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
                        <a href="?p=public.cookie">Cookie</a> &middot;
                        <a href="?p=public.privacy">Privacy</a> &middot;
	        			<a href="http://wiki.gaia.cri.it"><strong>Guida</strong></a> &middot;
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

                <?php if ( $me && $me->admin && !$me->admin() ) { ?>
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
                            <h4 class="text-error">Presta molta attenzione alle indicazioni</h4>
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

                <?php if ( $me && $me->supporto && !$me->supporto() ) { ?>
                <!-- SUPPORT MODE NON ATTIVATA -->
                <div id="supportMode" class="modal hide fade" role="dialog">
                    <div class="modal-header">
                        <h3>
                            <i class="icon-github-alt icon-large"></i>
                            Stai per entrare nella modalità di supporto
                        </h3>
                    </div>
                    <div class="modal-body">
                    	<p>
                    	<em>Da grandi poteri derivano grandi responsabilità</em>.
                    	</p>
                        <p>Entrando nella modalità di supporto entrerai in contatto con una grande mole
                            di dati sensibili di persone che ti hanno indirettamente dato la loro fiducia.</p>
                            <p>
                                &mdash;
                                <strong class="text-success">
                                    Per questo ti chiediamo di rinnovare la tua promessa.
                                </strong>
                            </p>
                            <h4 class="text-error">Io sottoscritto <?php echo $me->nome; ?> <?php echo $me->cognome; ?>, dichiaro di:</h4>
                            <ol>
                                <li>Rispettare la privacy degli altri;</li>
                                <li>Pensare sempre prima di scrivere e cliccare;</li>
                                <li>Non aprire alcuna anagrafica e/o modificare alcun dato a patto che non vi sia un ticket di assistenza;</li>
                                <li>Segnalare ogni criticità agli amministratori di sistema.</li>
                            </ol>
                            
                           <p class="text-info">
                                <i class="icon-time"></i>
                                Rimarrai in modalità admin fino al Logout
                            </p>
                            
                            	<p>
                                <p>Gli amministratori saranno in grado di verificare ogni operazioni da te effettuata (ricerca,modifica,etc)</p>
                                <p></p>
                                <p><strong>Il mancato rispetto di queste indicazioni comporterà la revoca dei permessi che ti sono stati delegati con conseguente esplusione dal centro di supporto.</strong></p>
                                </p>
                            </p>

                        </div>
                        <div class="modal-footer">
                            <a href="#" data-dismiss="modal" class="btn">Annulla</a>
                            <a href="?p=support.mode" class="btn btn-danger">
                                <i class="icon-ok"></i>
                                Okay, lo prometto ed accetto queste condizioni
                            </a>
                        </div>
                    </div>
                    <?php } ?>




                    <!-- Fine codice statistiche -->

                    <!-- DEBUG. Q: <?php echo $db->numQuery; ?>; M: <?php echo ceil(memory_get_peak_usage()/1024); ?> kB; T: <?php echo round(microtime(true)-$_stopwatch, 6); ?>s -->
                    
                    <?php if($conf['debug']) { ?>
                        <script type="text/javascript">var DEBUG = true;</script>

                    <?php } else { ?>

    					<!-- CHAT SUPPORTO -->
    					<div id="swifttagcontainer7nxkd9vwdw"><div id="proactivechatcontainer7nxkd9vwdw"></div><div style="display: inline;" id="swifttagdatacontainer7nxkd9vwdw"></div></div> <script type="text/javascript">var swiftscriptelem7nxkd9vwdw=document.createElement("script");swiftscriptelem7nxkd9vwdw.type="text/javascript";var swiftrandom = Math.floor(Math.random()*1001); var swiftuniqueid = "7nxkd9vwdw"; var swifttagurl7nxkd9vwdw="https://helpdesk.cri.it/visitor/index.php?/Gaia/LiveChat/HTML/SiteBadge/cHJvbXB0dHlwZT1jaGF0JnVuaXF1ZWlkPTdueGtkOXZ3ZHcmdmVyc2lvbj00LjY4LjEmcHJvZHVjdD1mdXNpb24mZmlsdGVyZGVwYXJ0bWVudGlkPTUwJnJvdXRlY2hhdHNraWxsaWQ9Myw0JnNpdGViYWRnZWNvbG9yPXdoaXRlJmJhZGdlbGFuZ3VhZ2U9ZW4mYmFkZ2V0ZXh0PWxpdmVoZWxwJm9ubGluZWNvbG9yPSMxYWEzMWEmb25saW5lY29sb3Job3Zlcj0jNWZiZjVmJm9ubGluZWNvbG9yYm9yZGVyPSMxMjcyMTImb2ZmbGluZWNvbG9yPSNmZjAwMDAmb2ZmbGluZWNvbG9yaG92ZXI9I2ZmNGQ0ZCZvZmZsaW5lY29sb3Jib3JkZXI9I2IzMDAwMCZhd2F5Y29sb3I9I2VlZmYwMCZhd2F5Y29sb3Job3Zlcj0jZjRmZjRkJmF3YXljb2xvcmJvcmRlcj0jYTdiMzAwJmJhY2tzaG9ydGx5Y29sb3I9I2ZmNzcwMCZiYWNrc2hvcnRseWNvbG9yaG92ZXI9I2ZmYTA0ZCZiYWNrc2hvcnRseWNvbG9yYm9yZGVyPSNiMzUzMDAmY3VzdG9tb25saW5lPSZjdXN0b21vZmZsaW5lPSZjdXN0b21hd2F5PSZjdXN0b21iYWNrc2hvcnRseT0KODMxODAxYmRmNWY0N2VmYzQ4YjFiNzZlMjhlYWFmNmRhOGVlNWEwNw==";setTimeout("swiftscriptelem7nxkd9vwdw.src=swifttagurl7nxkd9vwdw;document.getElementById('swifttagcontainer7nxkd9vwdw').appendChild(swiftscriptelem7nxkd9vwdw);",1);</script>
    					<!-- FINE CODICE TAG - NON MODIFICARE! -->

		                <!-- Google Analytics -->
		                <script>
                            var DEBUG = false;

		                    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		                        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		                    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		                    ga('create', 'UA-51942737-1', 'cri.it');
                            ga('set', 'anonymizeIp', true);
		  					ga('require', 'displayfeatures');
		                    ga('send', 'pageview');

		                </script>
                    <?php } ?>
                </body>
                </html><?php 
                ob_end_flush(); 
                header("Content-length: " . ob_get_length()); 
                ob_end_flush();
