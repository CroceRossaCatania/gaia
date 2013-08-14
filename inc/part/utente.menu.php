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

if ( $me->comitatiDiCompetenza() ) {
    $presidente = true;
    $menu[''] += [
        'presidente.dash'   =>  '<span class="badge badge-success">&nbsp;</span> Presidente'
    ];
}

if ( $presidente || $me->delegazioni(APP_SOCI)) {
    $menu[''] += [
        'us.dash'   =>  '<span class="badge badge-success">&nbsp;</span> Ufficio Soci'
    ];
}

if ( $presidente || $me->delegazioni(APP_CO)) {
    $menu[''] += [
        'co.dash'   =>  '<span class="badge badge-success">&nbsp;</span> Centrale Operativa'
    ];
}

if ( $presidente || $me->delegazioni(APP_OBIETTIVO)) {
    $menu[''] += [
        'obiettivo.dash'   =>  '<span class="badge badge-success">&nbsp;</span> Delegato d\'Area'
    ];
}

$nap = count($me->autorizzazioniPendenti());
if ( $nap ) {
    $menu['Da fare'] += [
            'attivita.autorizzazioni'   =>  '<span class="badge badge-important">' . $nap .'</span>&nbsp; Autorizzazioni '
    ];
}



$menu += [
    'Attività'      =>  [
        'attivita'  =>  '<i class="icon-calendar"></i> Calendario',
        'attivita.storico'  =>  '<i class="icon-list"></i> Mie attivita',
        'utente.gruppo'  =>  '<i class="icon-group"></i> Gruppi',
        'utente.reperibilita'  =>  '<i class="icon-thumbs-up"></i> Reperibilità'
    ],
    
    'Volontario'    =>  [
        'utente.anagrafica' =>  '<i class="icon-edit"></i> Anagrafica',
        'utente.storico'    =>  '<i class="icon-time"></i> Storico',
        'utente.documenti'  =>  '<i class="icon-folder-open"></i> Documenti'
        
    ],
    'Segreteria'      =>  [
        'utente.trasferimento'  =>  '<i class="icon-arrow-right"></i> Trasferimenti',
        'utente.riserva'  =>  '<i class="icon-pause"></i> Riserva',
        'utente.rubricaReferenti'  =>  '<i class="icon-book"></i> Rubrica',
       
        
    ],
    'Curriculum'    =>  [
        'utente.titoli&t=0' =>  '<i class="icon-magic"></i> Competenze pers.',
        'utente.titoli&t=1' =>  '<i class="icon-fighter-jet"></i> Patenti Civili',
        'utente.titoli&t=2' =>  '<i class="icon-ambulance"></i> Patenti CRI',
        'utente.titoli&t=3' =>  '<i class="icon-beaker"></i> Titoli di studio',
        'utente.titoli&t=4' =>  '<i class="icon-plus-sign-alt"></i> Titoli CRI'
    ],
    'Comunicazioni' =>  [
        'utente.email'     =>   '<i class="icon-envelope-alt"></i> Email',
        'utente.cellulare' =>   '<i class="icon-phone"></i> Cellulare'
    ],
    'Impostazioni' =>  [
        'utente.password'     =>   '<i class="icon-key"></i> Password'
    ],
    'Statistiche' =>  [
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

