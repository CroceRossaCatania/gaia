<?php

/*
* ©2013 Croce Rossa Italiana
*/

paginaPrivata();
controllaParametri(array('id'));

$corso = CorsoBase::id($_GET['id']);
paginaCorsoBase($corso);

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
            <form method="POST" action="?p=formazione.corsibase.finalizza.ok">
            <table class="table">
                <?php 
                $i = 0;
                foreach($part as $p) { ?>
                    <tr>
                        <td><?= $p->utente()->nomeCompleto(); ?></td>
                        <td>
                            <label class="radio">
                            <input type="radio" name="ammissione_<?= $p->id; ?>" 
                             id="ammesso_<?= $i; ?>" value="ammesso_<?= $p->id; ?>" >
                            Ammesso
                            </label>
                        </td>
                        <td>
                            <label class="radio">
                            <input type="radio" name="ammissione_<?= $p->id; ?>" 
                             id="non_<?= $i; ?>" value="non_<?= $p->id; ?>" >
                            Non Ammesso
                            </label>
                        </td>
                        <td>
                            <label class="radio">
                            <input type="radio" name="ammissione_<?= $p->id; ?>" 
                             id="assente_<?= $i; ?>" value="assente_<?= $p->id; ?>" >
                            Assente
                            </label>
                        </td>
                    </tr>
                    <tr class="nascosto" id="opt_ammesso_<?= $i; ?>">
                    <td>asd</td><td>asd</td><td>asd</td><td>asd</td>
                    </tr>
                    <tr class="nascosto" id="opt_non_<?= $i; ?>">
                    <td>axd</td><td>axd</td><td>axd</td><td>axd</td>
                    </tr>
                <?php 
                $i++;
                } ?>
            </table>
            <button type="submit" class="btn btn-success btn-block">
                <i class="icon-check"></i> Salva verbale
            </button>
            </form>
        </div>
    </div>
</div>


