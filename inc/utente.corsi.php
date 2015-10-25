<?php
/*
 * ©2013 Croce Rossa Italiana
 */

if (isset($_GET['t'])) {
    $t = (int) $_GET['t'];
} else {
    $t = 0;
}
$titoli = $conf['Corsi'][$t];

$province = Utility::elencoProvincie();
//$tipologie = Corso::getAllCertificati();
$tipologie = TipoCorso::elenco();


paginaPrivata();
?>
<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    
    <div class="span9">
        <h2>
             <i class="icon-calendar muted" id="icona-caricamento"></i>
            Calendario delle attività
        </h2>

        <div class="row-fluid" id="calendario" style="margin-top: 50px"></div>

        <ul style="list-style-type: none; display: inline;">
            <li style="list-style-type: none; display: inline; margin-right: 10px;"><i class="icon-sign-blank" style="color: #cccccc"></i> Discente</li>
            <li style="list-style-type: none; display: inline; margin-right: 10px;"><i class="icon-sign-blank" style="color: #ffff00"></i> Docente</li>
            <li style="list-style-type: none; display: inline; margin-right: 10px;"><i class="icon-sign-blank" style="color: #ff00ff"></i> Istruttore</li>
            <li style="list-style-type: none; display: inline;"><i class="icon-sign-blank" style="color: #00ffff"></i> Formatore</li>
        </ul>
    </div>
</div>