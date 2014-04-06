<?php

/*
* ©2014 Croce Rossa Italiana
*/

paginaPrivata();
controllaParametri(array('id'));

$corso = CorsoBase::id($_GET['id']);
paginaCorsoBase($corso);

if($corso->stato == CORSO_S_CONCLUSO) {
    redirect("formazione.corsibase.scheda&id={$corso->id}&err");
}

$part = $corso->partecipazioni(ISCR_CONFERMATA);

?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>


    </div>

    <div class="span9">
        <h2>
            <i class="icon-flag-checkered muted"></i>
            Compilazione verbale Corso Base
        </h2>
        <div class="row-fluid">
            <form method="POST" action="?p=formazione.corsibase.finalizza.ok" class="form-horizontal">
            <input type="hidden" name="id" value="<?php echo $corso->id; ?>" />
            <table class="table">
                <?php 
                foreach($part as $p) { ?>
                    <tr data-riga="<?= $p->id; ?>" class="compila-prima-riga" id="riga_<?= $p->id; ?>">
                        <td><strong><?= $p->utente()->nomeCompleto(); ?></strong></td>
                        <td>
                            <label class="radio">
                            <input type="radio" name="ammissione_<?= $p->id; ?>" 
                             data-ammesso="<?= $p->id; ?>" value="1" >
                            Ammesso
                            </label>
                        </td>
                        <td>
                            <label class="radio">
                            <input type="radio" name="ammissione_<?= $p->id; ?>" 
                             data-non="<?= $p->id; ?>" value="2" >
                            Non Ammesso
                            </label>
                        </td>
                        <td>
                            <label class="radio">
                            <input type="radio" name="ammissione_<?= $p->id; ?>" 
                             data-assente="<?= $p->id; ?>" value="3" >
                            Assente
                            </label>
                        </td>
                    </tr>
                    <tr class="nascosto" id="opt_p1_<?= $p->id; ?>">
                        <td colspan="2">
                           Parte 1: La croce rossa 
                        </td>
                        <td>
                            <label class="radio">
                                <input type="radio" name="p1_<?= $p->id; ?>"  id="ct1_<?= $p->id; ?>"
                                value="1" >
                                Positivo
                            </label>
                        </td>
                        <td>
                            <label class="radio">
                                <input type="radio" name="p1_<?= $p->id; ?>" id="cf1_<?= $p->id; ?>"
                                value="0" >
                                Negativo
                            </label>
                        </td>
                    </tr>
                    <tr class="nascosto" id="opt_p2_<?= $p->id; ?>">
                        <td colspan="2">
                           Parte 2: Gesti e manovre salvavita 
                        </td>
                        <td>
                            <label class="radio">
                                <input class="p2_<?= $p->id; ?>" type="radio" name="p2_<?= $p->id; ?>" id="ct2_<?= $p->id; ?>"
                                value="1" >
                                Positivo
                            </label>
                        </td>
                        <td>
                            <label class="radio">
                                <input class="p2_<?= $p->id; ?>" type="radio" name="p2_<?= $p->id; ?>" id="cf2_<?= $p->id; ?>"
                                value="0" >
                                Negativo
                            </label>
                        </td>
                    </tr>
                    <tr class="nascosto" id="opt_p3_<?= $p->id; ?>">
                        <td colspan="2" id="tdex1_<?= $p->id; ?>">
                           <label class="checkbox inline">
                                <input type="checkbox" id="extra_1_<?= $p->id; ?>"
                                 name="extra_1_<?= $p->id; ?>" value="1"> 
                                 Prova pratica su Parte 2 sostituita da colloquio
                            </label>
                        </td>
                        <td colspan="2">
                            <label class="checkbox inline">
                                <input type="checkbox" data-extra2="<?= $p->id; ?>" id="ex2_<?= $p->id; ?>"
                                 name="extra_2_<?= $p->id; ?>" value="1"> 
                                 Verifica effettuata solo sulla Parte 1 del programma del corso
                            </label>
                        </td>
                    </tr>
                    <tr class="nascosto error" id="opt_non_<?= $p->id; ?>">
                        <td colspan="4">
                            <div class="control-group">
                                <label class="control-label" for="inputMotivo_<?= $p->id; ?>">Motivo</label>
                                <div class="controls">
                                    <input type="text" class="input-block-level" id="inputMotivo_<?= $p->id; ?>" name="inputMotivo_<?= $p->id; ?>"
                                     placeholder="es: numero di assenze superiore al previsto">
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <button type="submit" class="btn btn-success btn-block nascosto" id="pulsantone">
                <i class="icon-check"></i> Salva verbale
            </button>
            </form>
        </div>
    </div>
</div>


