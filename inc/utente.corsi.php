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
$tipologie = Certificato::elenco();


paginaPrivata();
?>
<div class="row-fluid">
    <div class="span3">
<?php menuVolontario(); ?>
    </div>
    <div class="span9">

         <h2><i class="icon-calendar muted" id="icona-caricamento"></i>
            Calendario delle attività</h2>

        <legend>
            <ul>
                <li>Discente - colore</li>
                <li>Docente - colore</li>
                <li>Istruttore - colore</li>
                <li>Formatore - colore</li>
            </ul>
        </legend>


        <div class="row-fluid">

                    <div class="span12">
                        <h4>Filtri</h4>

                        <div class="row-fluid">
                            <div class="span6">
                                <label for="provincia">Comitato</label>
                                <select id="provincia" data-placeholder="Scegli una provincia..." id="cercaProvicia" class="chosen-select" style="width: 350px;" multiple="true">
                                    <option></option>
                                    <?php foreach ($province as $tmp) : ?>
                                        <option value="<?php echo $tmp ?>"><?php echo $tmp ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="span6">
                                <label for="findme">Usa la mia posizione</label>
                                <a href="#" data-role="findme" class="btn" role="button">
                                    <i class="icon-map-marker icon-large"></i>&nbsp;Trovami
                                </a>
                                <span id="geo_dati"></span>
                            </div>
                        </div>
                        <div class="row-fluid" style="margin-top: 25px">

                            <label for="type">Tipologia</label>
                            <select id="type" class="chosen-select" data-placeholder="Aggiungi un filtro..." style="width:350px;" multiple="true">
                                <option></option>
                                <?php foreach ($tipologie as $t) : ?>
                                    <option value="<?php echo $t ?>"><?php echo $t ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
       
                <hr />
               
            </div>

             <div class="row-fluid" id="calendario" style="margin-top: 50px"></div>

        </div>

    </div>
</div>