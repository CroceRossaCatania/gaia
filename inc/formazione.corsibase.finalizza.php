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

$partecipazioni = $corso->partecipazioni(ISCR_CONFERMATA);

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
            <div class="alert alert-panel alert-warning nascosto" id="messaggio">
                <strong><i class="icon-warning-sign"></i> Presta molta attenzione!</strong>
                I dati non sono ancora stati salvati, ti preghiamo di perdere ancora qualche minuto
                per rileggeri ed essere <b>veramente sicuro</b> di ciò che stai facendo. Una volta
                effettuata questa operazione non sarà possibile apportare correzioni in caso di errore.
            </div>
            <form method="POST" action="?p=formazione.corsibase.finalizza.ok" class="form-horizontal" id="verbale">
            <input type="hidden" name="id" value="<?php echo $corso->id; ?>" />
            <table class="table">
                <?php 
                foreach($partecipazioni as $part) { ?>
                    <tr data-riga="<?= $part->id; ?>" class="compila-prima-riga" id="riga_<?= $part->id; ?>">
                        <td><strong><?= $part->utente()->nomeCompleto(); ?></strong></td>
                        <td>
                            <label class="radio">
                            <input type="radio" name="ammissione_<?= $part->id; ?>" 
                             data-ammesso="<?= $part->id; ?>" value="1" >
                            Ammesso
                            </label>
                        </td>
                        <td>
                            <label class="radio">
                            <input type="radio" name="ammissione_<?= $part->id; ?>" 
                             data-non="<?= $part->id; ?>" value="2" >
                            Non Ammesso
                            </label>
                        </td>
                        <td>
                            <label class="radio">
                            <input type="radio" name="ammissione_<?= $part->id; ?>" 
                             data-assente="<?= $part->id; ?>" value="3" >
                            Assente
                            </label>
                        </td>
                    </tr>
                    <tr class="nascosto" id="opt_p1_<?= $part->id; ?>">
                        <td colspan="2">
                           Parte 1: La croce rossa 
                        </td>
                        <td>
                            <label class="radio">
                                <input type="radio" name="p1_<?= $part->id; ?>"  id="ct1_<?= $part->id; ?>"
                                value="1" >
                                Positivo
                            </label>
                        </td>
                        <td>
                            <label class="radio">
                                <input type="radio" name="p1_<?= $part->id; ?>" id="cf1_<?= $part->id; ?>"
                                value="0" >
                                Negativo
                            </label>
                        </td>
                    </tr>
                    <tr class="nascosto" id="arg_p1_<?= $part->id; ?>">
                        <td colspan="1">
                           Argomenti: 
                        </td>
                        <td colspan="3">
                            <label class="controls">
                                <input class="arg_p1_<?= $part->id; ?>" type="text" name="arg_p1_<?= $part->id; ?>" placeholder="Es: Storia della CRI, DIU">
                            </label>
                        </td>
                    </tr>
                    <tr class="nascosto" id="opt_p2_<?= $part->id; ?>">
                        <td colspan="2">
                           Parte 2: Gesti e manovre salvavita 
                        </td>
                        <td>
                            <label class="radio">
                                <input class="p2_<?= $part->id; ?>" type="radio" name="p2_<?= $part->id; ?>" id="ct2_<?= $part->id; ?>"
                                value="1" >
                                Positivo
                            </label>
                        </td>
                        <td>
                            <label class="radio">
                                <input class="p2_<?= $part->id; ?>" type="radio" name="p2_<?= $part->id; ?>" id="cf2_<?= $part->id; ?>"
                                value="0" >
                                Negativo
                            </label>
                        </td>
                    </tr>
                    <tr class="nascosto" id="arg_p2_<?= $part->id; ?>">
                        <td colspan="1">
                           Argomenti: 
                        </td>
                        <td colspan="3">
                            <label class="controls">
                                <input class="arg_p2_<?= $part->id; ?>" type="text" name="arg_p2_<?= $part->id; ?>" placeholder="Es: BLS, colpo di calore">
                            </label>
                        </td>
                    </tr>
                    <tr class="nascosto" id="opt_p3_<?= $part->id; ?>">
                        <td colspan="2" id="tdex1_<?= $part->id; ?>">
                           <label class="checkbox inline">
                                <input type="checkbox" id="extra_1_<?= $part->id; ?>"
                                 name="extra_1_<?= $part->id; ?>" value="1"> 
                                 Prova pratica su Parte 2 sostituita da colloquio
                            </label>
                        </td>
                        <td colspan="2">
                            <label class="checkbox inline">
                                <input type="checkbox" data-extra2="<?= $part->id; ?>" id="ex2_<?= $part->id; ?>"
                                 name="extra_2_<?= $part->id; ?>" value="1"> 
                                 Verifica effettuata solo sulla Parte 1 del programma del corso
                            </label>
                        </td>
                    </tr>
                    <tr class="nascosto error" id="opt_non_<?= $part->id; ?>">
                        <td colspan="4">
                            <div class="control-group">
                                <label class="control-label" for="inputMotivo_<?= $part->id; ?>">Motivo</label>
                                <div class="controls">
                                    <input type="text" class="input-block-level" id="inputMotivo_<?= $part->id; ?>" name="inputMotivo_<?= $part->id; ?>"
                                     placeholder="es: numero di assenze superiore al previsto">
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <button type="submit" class="btn btn-success btn-large btn-block nascosto" id="salva">
                Salva verbale
            </button>
            </form>
            <a href="?p=formazione.corsibase.finalizza&id=<?= $_GET['id'] ?>" 
                class="btn btn-danger btn-large btn-block nascosto" id="annulla" type="button">
                Ricompila verbale
            </a>
            <button class="btn btn-success btn-block nascosto" id="pulsantone">
                <i class="icon-check"></i> Salva verbale
            </button>
        </div>
    </div>
</div>


