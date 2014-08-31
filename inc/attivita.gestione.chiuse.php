<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPrivata();

$mieAree = $me->areeDiCompetenza();

?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        <div class="row-fluid">
            <div class="span7">
                <h2>
                    <i class="icon-star muted"></i>
                    Gestione delle attività chiuse
                </h2>
            </div>
            <div class="span5">
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <?php if (isset($_GET['err'])) { ?>
                    <div class="alert alert-block alert-error">
                        <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
                        <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
                    </div> 
                <?php } ?> 
                <?php if (isset($_GET['aperta'])) { ?>
                    <div class="alert alert-block alert-success">
                        <h4><i class="icon-remove-sign"></i> <strong>Attività aperta</strong>.</h4>
                        <p>Troverai l'attività andando nel menù a sx e cliccando gestisci attivita.</p>
                    </div> 
                <?php } ?>
                <table class="table table-striped table-bordered">

                    <thead>
                        <th>
                            Attività
                        </th>
                        <th>
                            Comitato
                        </th>
                        <th>
                            Area
                        </th>

                        <th>
                            Azione
                        </th>
                    </thead>

                    <?php foreach ( $me->attivitaDiGestione(ATT_CHIUSA) as $attivita ) { ?>

                    <tr>
                        <td style="width: 40%;">
                            <strong>
                                <a href="?p=attivita.scheda&id=<?php echo $attivita->id; ?>">
                                    <?php echo $attivita->nome; ?>
                                </a>
                            </strong><br />
                            <?php echo $attivita->luogo; ?>
                            <br />
                            <?php if ( $attivita->referente ) { ?>
                            Referente: 
                            <a href="?p=profilo.controllo&id=<?php echo $attivita->referente()->id; ?>" target="_new">
                                <?php echo $attivita->referente()->nomeCompleto(); ?>
                            </a>
                            <?php } else { ?>
                            <i class="icon-warning-sign"></i> Nessun referente
                            <?php } ?>
                        </td>
                        
                        <td style="width: 20%;">
                            <?php echo $attivita->comitato()->nomeCompleto(); ?>
                        </td>
                        
                        <td style="width: 20%;">
                            <?php echo $attivita->area()->nomeCompleto(); ?>
                        </td>
                        
                        
                        <td style="width: 20%;">
                            <?php if (in_array($attivita->area(), $mieAree) || $me->admin()){ ?>
                            <a href="?p=attivita.referente.nuovo&id=<?= $attivita->id; ?>">
                                <i class="icon-pencil"></i> 
                                cambia referente
                            </a>
                            <br />
                            <a href="?p=attivita.apertura.ok&apri&id=<?= $attivita->id; ?>" onclick="return confirm('Sei sicuro di voler chiudere l'attività?');">
                                <i class="icon-remove"></i> 
                                apri attività
                            </a>
                            <br />
                            <?php } ?>
                            <a href="?p=attivita.modifica&id=<?php echo $attivita->id; ?>">
                                <i class="icon-edit"></i> modifica attività
                            </a>
                            <br />
                            <a href="?p=attivita.turni&id=<?php echo $attivita->id; ?>">
                                <strong><i class="icon-plus"></i> giorni e turni</strong>
                            </a>        
                            <br />
                            <a href="?p=attivita.report&id=<?php echo $attivita->id; ?>" data-attendere="Generazione in corso...">
                                <i class="icon-download-alt"></i> scarica report
                            </a>
                        </td>
                        
                    </tr>

                    <?php } ?>

                </table>
            </div>
        </div>
    </div>
</div>
