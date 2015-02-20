<?php

/*
 * ©2013 Croce Rossa Italiana
 */

global $me;

$menu = [];

$menu += [
    '' => [
        'utente.me'         =>  '<i class="icon-bolt"></i> Benvenuto'
    ],
    'Da fare'   =>   []
];

$presidente = false;

if ( $me && ($me->admin() || $me->delegazioneAttuale()->applicazione == APP_PRESIDENTE )) {
    $presidente = true;
    $menu[''] += [
        'presidente.dash'   =>  '<span class="badge badge-success">&nbsp;</span> Presidente'
    ];
}

if ($me && (!$me->admin() && $me->delegazioneAttuale()->applicazione == APP_SOCI)) {
$_n     =   $_n_titoli = $_n_app = 0;
$_n     +=  $_n_titoli = $me->numTitoliPending  ([APP_PRESIDENTE, APP_SOCI]);
$_n     +=  $_n_app    = $me->numAppPending     ([APP_PRESIDENTE, APP_SOCI]);

    $menu[''] += [
        'us.dash'   =>  '<span class="badge badge-success">'.$_n.'</span> Ufficio Soci'
    ];
} elseif ($presidente) {
    $menu[''] += [
        'us.dash'   =>  '<span class="badge badge-success">&nbsp;</span> Ufficio Soci'
    ];
}

if ( $presidente || ($me && $me->delegazioneAttuale()->applicazione == APP_CO)) {
    $menu[''] += [
        'co.dash'   =>  '<span class="badge badge-success">&nbsp;</span> Centrale Operativa'
    ];
}

/* blocco aspiranti */
if ( $presidente || 
     ($me && $me->delegazioneAttuale()->applicazione == APP_FORMAZIONE) || 
     ($me && $me->corsiBaseDiGestione()) ) {
    $menu[''] += [
        'formazione.corsibase'   =>  '<span class="badge badge-success">&nbsp;</span> Corsi Base'
    ];
}

if ( $presidente || ($me && $me->delegazioneAttuale()->applicazione == APP_OBIETTIVO)) {
    $menu[''] += [
        'obiettivo.dash'   =>  '<span class="badge badge-success">&nbsp;</span> Delegato d\'Area'
    ];
}

if ( $presidente || ($me && $me->delegazioneAttuale()->applicazione == APP_AUTOPARCO)) {
    $menu[''] += [
        'autoparco.dash'   =>  '<span class="badge badge-success">&nbsp;</span> Autoparco'
    ];
}

$nap = count($me->autorizzazioniPendenti());
if ( $nap ) {
    $menu['Da fare'] += [
            'attivita.autorizzazioni'   =>  '<span class="badge badge-important">' . $nap .'</span>&nbsp; Autorizzazioni '
    ];
}


if ($me && ($me->attivitaDiGestione() || $me->comitatiAreeDiCompetenza() || $me->attivitaReferenziate())) {
    $menu += [
        'Attività'      =>  [
            'attivita'  =>  '<i class="icon-calendar"></i> Calendario',
            'attivita.storico'  =>  '<i class="icon-list"></i> Miei turni',
            'attivita.gestione'  =>  '<i class="icon-star"></i> Gestisci attività',
            'utente.gruppo'  =>  '<i class="icon-group"></i> Gruppi',
            'utente.reperibilita'  =>  '<i class="icon-thumbs-up"></i> Reperibilità'
        ]];
} else {
    $menu += [
        'Attività'      =>  [
            'attivita'  =>  '<i class="icon-calendar"></i> Calendario',
            'attivita.storico'  =>  '<i class="icon-list"></i> Miei turni',
            'utente.gruppo'  =>  '<i class="icon-group"></i> Gruppi',
            'utente.reperibilita'  =>  '<i class="icon-thumbs-up"></i> Reperibilità'
        ]];
}
$menu += [ 
    'Volontario'    =>  [
        'utente.anagrafica' =>  '<i class="icon-edit"></i> Anagrafica',
        'utente.storico'    =>  '<i class="icon-time"></i> Storico',
        'utente.documenti'  =>  '<i class="icon-folder-open"></i> Documenti',
        'utente.posta'     =>   '<i class="icon-envelope-alt"></i> Posta'           
    ]];
if ($me && $me->unComitato()) {
    $menu += [
        'Segreteria'      =>  [
            'utente.estensione'  =>  '<i class="icon-random"></i> Estensioni',
            'utente.trasferimento'  =>  '<i class="icon-arrow-right"></i> Trasferimenti',
            'utente.riserva'  =>  '<i class="icon-pause"></i> Riserva',
            'utente.rubricaReferenti'  =>  '<i class="icon-book"></i> Rubrica',
            'public.tesserino'  =>  '<i class="icon-credit-card"></i> Verifica Tesserino'  
        ]];
}
$menu += [
    'Curriculum'    =>  [
        'utente.titoli&t=0' =>  '<i class="icon-magic"></i> Competenze pers.',
        'utente.titoli&t=1' =>  '<i class="icon-fighter-jet"></i> Patenti Civili',
        'utente.titoli&t=2' =>  '<i class="icon-ambulance"></i> Patenti CRI',
        'utente.titoli&t=3' =>  '<i class="icon-beaker"></i> Titoli di studio',
        'utente.titoli&t=4' =>  '<i class="icon-plus-sign-alt"></i> Titoli CRI'
    ]];
$menu += [
	'Donazioni'     => [
		'utente.donazioni&d=0' => '<i class="icon-beaker"></i> Sangue'
	]];
if ( $me->iVeGotThePower() ) {
	$menu['Donazioni'] += [ 'donazioni.report' => '<i class="icon-copy"></i> Report' ];
}
$menu += [
    'Statistiche'   => [
        'utente.statistiche.volontari'     =>   '<i class="icon-puzzle-piece"></i> Volontari'
//        'utente.statistiche.attivita'     =>   '<i class="icon-weibo"></i> Attività'
    ]
];

?>
<div class="well hidden-phone" style="padding: 8px 0px;">
    <ul class="nav nav-list">      
        <?php global $p; ?>
        <?php foreach ($menu as $sezione => $contenuto ) { 
            if (!$contenuto) {continue; }?>
        <li class="nav-header"><?php echo $sezione; ?></li>
            <?php foreach ($contenuto as $link => $scelta) { 
                $larray = explode('&', $link);?>
                <li <?php if ( (!isset($_GET['t']) && $larray[0] == $p) or (isset($_GET['t']) && $larray[1] == "t={$_GET['t']}") ) { ?>class="active"<?php } ?>>
                    <a href="?p=<?php echo $link; ?>">
                        <?php echo $scelta; ?>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
</div>

<div id="navigatoreMobile" class="visible-phone">
    <select id='navigatoreMobileSelect'>
        <?php foreach ($menu as $sezione => $elenco) { ?>
            <?php if ( !empty($sezione) ) { ?>
                <option value=''>== <?php echo $sezione; ?> ==</option>
            <?php } ?>
            <?php foreach ( $elenco as $href => $valore ) { 
                $y = false;
                $larray = explode('&', $href); ?>
                <option 
                    <?php if ( (!isset($_GET['t']) && $larray[0] == $p) or (isset($_GET['t']) && $larray[1] == "t={$_GET['t']}") ) { $y = true; ?>selected="selected"<?php } ?>
                    value="<?php echo $href; ?>">
                    <?php if ( $y ) { ?>Menu:<?php } ?>
                        <?php echo $valore; ?>
                </option>
            <?php } ?>
        <?php } ?>
    </select>
    <hr />
</div>

