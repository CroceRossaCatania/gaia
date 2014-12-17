<?php

paginaPrivata();

if ( $me->stato != ASPIRANTE )
    redirect('utente.me');

$corso = $me->partecipazioniBase(ISCR_RICHIESTA); 


?>




<div class="row-fluid">
    <div class="span3">
        <?php menuAspirante(); ?>

    </div>
    <div class="span9">
        <h2><i class="icon-list"></i> Elenco dei Corsi Base a cui sei preiscritto</h2>
        <?php if(isset($_GET['err'])) { ?>
            <div class="alert alert-block alert-error">
            <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
            <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
            </div> 

        <?php } ?>

        <div class="row-fluid">
            <div class="span12">

                <table class="table table-striped table-bordered">
                    <thead>
                        <th> 
                            Organizzatore
                        </th>
                        <th>
                            Data e luogo inizio
                        </th>
                        <th>
                            Stato
                        </th>

                        <th>
                            Azione
                        </th>
                    </thead>
                    <tbody>
                        <?php foreach ($corso as $partecipazione) { 
                            $cb = $partecipazione->corsoBase(); ?>
                            <tr>
                                <td><?= $cb->organizzatore()->nomeCompleto(); ?></td>
                                <td><?= $cb->inizio()->inTesto(false); ?> presso <?= $cb->luogo; ?></td>
                                <td><?= $conf['partecipazioneBase'][$partecipazione->stato]; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-small btn-info" 
                                         href="?p=formazione.corsibase.scheda&id=<?= $cb; ?>" title="Dettagli">
                                            <i class="icon-zoom-in"></i>
                                        </a>
                                        <?php if($cb->futuro()) { ?>
                                        <a class="btn btn-small btn-danger" 
                                         href="?p=formazione.corsibase.iscrizione.cancella.ok&id=<?= $cb; ?>" 
                                        title="Cancella preiscrizione">
                                            <i class="icon-trash"></i>
                                        </a>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


