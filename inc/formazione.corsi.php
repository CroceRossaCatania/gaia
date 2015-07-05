<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

$mieiComitati = $me->comitatiApp([APP_PRESIDENTE], false);

$province = Utility::elencoProvincie();
//$tipologie = Corso::getAllCertificati();
$tipologie = Certificato::elenco();
?>


<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">

        <div class="row-fluid">
            <div class="span7">
                <h2>
                    <i class="icon-calendar muted"></i>
                    Corsi
                </h2>
            </div>
            <div class="span5">  
                <?php if ( $me->presidenziante() || $me->admin()) { ?>
                <a href="?p=formazione.corsi.idea" class="btn btn-large btn-block btn-success">
                    <i class="icon-plus-sign"></i>
                    Attiva nuovo Corso
                </a>      
                <?php } ?>
            </div>
        </div>
    	

        <div class="row-fluid">
            <div class="span12">
                <h4>Filtri</h4>

                <div class="row-fluid">
                    <div class="span6">
                        <label for="provincia">Comitato</label>
                        <select id="provincia" data-placeholder="Scegli una provincia..." id="cercaProvicia" class="chosen-select" style="width: 350px;" multiple="true">
                            <option></option>
                            <?php  foreach($province as $tmp) :?>
                                <option value="<?php echo $tmp ?>"><?php echo $tmp ?></option>
                            <?php endforeach;   ?>
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
                        <?php foreach($tipologie as $t) :?>
                            <option value="<?php echo $t->id ?>"><?php echo $t->nome ?></option>
                        <?php endforeach;  ?>
                    </select>
                </div>
            </div>
        </div>
         <hr />
        <div class="row-fluid" id="calendario" style="margin-top: 50px"></div>
    
        <ul style="list-style-type: none; display: inline;">
            <li style="list-style-type: none; display: inline; margin-right: 10px;"><i class="icon-sign-blank" style="color: #cccccc"></i> Approvati</li>
            <li style="list-style-type: none; display: inline; margin-right: 10px;"><i class="icon-sign-blank" style="color: #ffff00"></i> Da Approvare</li>
            <li style="list-style-type: none; display: inline; margin-right: 10px;"><i class="icon-sign-blank" style="color: #ff00ff"></i> Da Validare</li>
            <li style="list-style-type: none; display: inline;"><i class="icon-sign-blank" style="color: #00ffff"></i> Validati</li>
        </ul>
    
    </div>
    
</div>