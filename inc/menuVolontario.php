<?php

/*
 * ©2012 Croce Rossa Italiana
 */

$menu = [
    '' => [
        'me'         =>  '<i class="icon-bolt"></i> Benvenuto'
    ],
    'Attività'      =>  [
        'attivita'  =>  '<i class="icon-calendar"></i> Calendario'
    ],
    'Volontario'    =>  [
        'anagrafica' =>  '<i class="icon-edit"></i> Anagrafica',
        'utente.storico'    =>  '<i class="icon-time"></i> Storico',
        'documenti'  =>  '<i class="icon-folder-open"></i> Documenti'
        
    ],
    'Segreteria'      =>  [
        'utente.trasferimento'  =>  '<i class="icon-arrow-right"></i> Trasferimenti',
        'utente.rubricaReferenti'  =>  '<i class="icon-book"></i> Rubrica'
        
    ],
    'Curriculum'    =>  [
        'titoli&t=0' =>  '<i class="icon-magic"></i> Competenze pers.',
        'titoli&t=1' =>  '<i class="icon-fighter-jet"></i> Patenti Civili',
        'titoli&t=2' =>  '<i class="icon-ambulance"></i> Patenti CRI',
        'titoli&t=3' =>  '<i class="icon-beaker"></i> Titoli di studio',
        'titoli&t=4' =>  '<i class="icon-plus-sign-alt"></i> Titoli CRI'
    ],
    'Comunicazioni' =>  [
        'utente.email'     =>   '<i class="icon-envelope-alt"></i> Email',
        'utente.cellulare' =>   '<i class="icon-phone"></i> Cellulare'
    ],
    'Impostazioni' =>  [
        'utente.password'     =>   '<i class="icon-key"></i> Password'
    ]
];

?>
<div class="well" style="padding: 8px 0px;">
    <ul class="nav nav-list">      
        <?php global $p; ?>
        <?php foreach ($menu as $sezione => $contenuto ) { ?>
        <li class="nav-header"><?php echo $sezione; ?></li>
            <?php foreach ($contenuto as $link => $scelta) { ?>
                <li <?php if ( substr($p, 0, 3) == substr($link, 0, 3) && (!isset($_GET['t']) or substr($link, 9, 1) == $_GET['t']) ) { ?>class="active"<?php } ?>>
                    <a href="?p=<?php echo $link; ?>">
                        <?php echo $scelta; ?>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
</div>
