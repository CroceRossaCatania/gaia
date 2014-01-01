<?php

/*
 * ©2013 Croce Rossa Italiana
 */

global $me;

$menu = [];

$menu += [
    '' => [
        'aspirante.home'         =>  '<i class="icon-bolt"></i> Benvenuto'
    ],
    'Aspirante'    =>  [
        'utente.anagrafica' =>  '<i class="icon-edit"></i> Anagrafica',
        'aspirante.localita' => '<i class="icon-map-marker"></i> Dove ti trovi?'       
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

