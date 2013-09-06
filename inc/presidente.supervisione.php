<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();

?>
<div class="row-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="span12 centrato">
                <h1><i class="icon-eye-close"></i> Supervisione</h1>
                <div class="alert alert-block alert-danger">
                    <p>Pagina dedicata ai Presidenti per la supervisione</p>
                </div>        
            </div>
            <hr/>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6 centrato">
            <div class='alert alert-info'>
                <strong>Volontari senza gruppi</strong>
                <p>Con questo modulo si potranno controllare tutti i volontari che non appartengo ad almeno un gruppo di lavoro</p>
            </div>
            <?php
            $comitati = $me->comitatiDiCompetenza();
            $nogruppi = True;
            foreach ($comitati as $c) {
                if ($c->gruppi()){
                    $nogruppi = False;
                    break;
                }
            }
            if ($nogruppi) { ?>
                <span class="text-error">
                    <i class="icon-warning-sign"></i>
                    Spiacente Presidente <br />
                    Attualmente nel suo Comitato non esistono gruppi di lavoro.
                </span>
            <?php } else { ?>
            <a href="?p=presidente.supervisione.nogruppo" class="btn btn-large btn-info">
                <i class="icon-group"></i>
                No Gruppo
            </a>
            <?php } ?>
        </div>
        
        <div class="span6 centrato">
            <!--<div class="alert alert-success">
                <strong>Volontari con 0 turni</strong>
                <p>Con questo modulo è possibile visualizzare tutti i volontari che non hanno effetuato turno in un dato mese</p>
            </div>
            <a href="?p=#" class="btn btn-large btn-success">
                <i class="icon-time"></i>
                No Turno
            </a>
        </div>-->
    </div>
</div>