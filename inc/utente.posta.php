<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata(); 

/* Roba che server solo per fare un po' di prove */

$m1 = new stdClass;
$m1->mittente = 1;
$m1->destinatario = $me->id;
$m1->oggetto = "Messaggio stupendiglioso";
$m1->testo = "Email veramente bella bla bla bla";
$m1->date = time();

$m2 = new stdClass;
$m2->mittente = 2;
$m2->destinatario = $me->id;
$m2->oggetto = "Messaggio stupendiglioso 2";
$m2->testo = "Email veramente bella bla bla bla";
$m2->date = time();

$m3 = new stdClass;
$m3->mittente = 1;
$m3->destinatario = $me->id;
$m3->oggetto = "Messaggio stupendiglioso 3";
$m3->testo = "Email veramente bella bla bla bla";
$m3->date = time();

$in = [$m1, $m2, $m3];

?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        <h2><i class="icon-envelope-alt muted"></i> Comunicazioni inviate e ricevute</h2>
        <hr />  
        <div class="row-fluid">
            <div class="span12"
                 data-posta     ="true"
                 data-perpagina ="20"
                 data-completo  ="true"
                 data-direzione ="ingresso"
                 data-azioni    ="#azioni_posta"
            ></div>
            <div id="azioni_posta" class="nascosto">
             [AZIONI]
            </div>
        <hr />

        <div data-utente="218">
            {nome}, {cognome}, {nomeCompleto}, <img src="{avatar}" />
        </div>

        <div class="row-fluid">
            <div class="span4">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_in" data-toggle="tab">Posta Ricevuta</a></li>
                        <li><a href="#tab_out" data-toggle="tab">Posta Inviata</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <!-- POSTA IN-->
                    <div class="tab-pane active" id="tab_in">
                        <div class="btn-group">
                            <!-- i pulsanti dovrebbero essere centrati o blocl -->
                            <button class="btn">Indietro</button>
                            <button class="btn">Avanti</button>
                        </div>
                        <br /><br />
                        <table class="table" id="postaIn">
                            <?php foreach($in as $_in) { 
                                $v = Utente::id($_in->mittente) ?>
                                <tr>
                                    <td><img src="<?php echo $v->avatar()->img(10); ?>" class="img-circle" /></td>
                                    <td><strong><?= $_in->oggetto ?></strong> <br /> <?=$v->nomeCompleto() ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>

                    <!-- POSTA OUT-->
                    <div class="tab-pane" id="tab_out">
                        <div
                            data-email="mittente"
                            data-perpagina="10"
                        >
                        </div>
                    </div>
                </div>
            </div>
            <div class="span8">
                <h3><?= $m1->oggetto ?></h3>
                Da: <?= Utente::id($m1->mittente)->nomeCompleto(); ?>
                <hr />
                <?php echo($m1->testo); ?>
            </div>
        </div>
    </div>
</div>