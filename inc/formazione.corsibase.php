<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();

$mieiComitati = $me->comitatiApp([APP_PRESIDENTE], false);

?>


<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">

        <div class="row-fluid">
            <div class="span7">
                <h2>
                    <i class="icon-ticket muted"></i>
                    Corsi Base
                </h2>
            </div>
            <div class="span5">  
                <?php if ( $me->presidenziante() || $me->admin()) { ?>
                <a href="?p=formazione.corsibase.idea" class="btn btn-large btn-block btn-success">
                    <i class="icon-plus-sign"></i>
                    Attiva nuovo Corso Base
                </a>      
                <?php } ?>
            </div>
        </div>
    	

		<div class="row-fluid">
            <div class="span12">
                <?php if (isset($_GET['err'])) { ?>
                <div class="alert alert-block alert-danger">
                    <h4><i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.</h4>
                    <p>L'operazione che stavi tentando di eseguire non è andata a buon fine. Per favore riprova.</p>
                </div> 
                <?php } ?> 
                <?php if (isset($_GET['cancellato'])) { ?>
                <div class="alert alert-block alert-success">
                    <h4><i class="icon-save"></i> <strong>Corso base cancellato</strong>.</h4>
                    <p>L'operazione hai eseguito è andata a buon fine.</p>
                </div> 
                <?php } ?> 
                <table class="table table-striped table-bordered">

                    <thead>
                        <th> 
                            Organizzatore
                        </th>
                        <th>
                            Data e luogo
                        </th>
                        <th>
                            Stato
                        </th>

                        <th>
                            Azione
                        </th>
                    </thead>

                    <?php 
                    if($me->admin()) {
                        $corsi = CorsoBase::elenco();
                    } else {
                        $corsi = $me->corsiBaseDiGestione();
                    }


                    foreach ( $corsi as $corso ) {

                        // autorisolutore problemi dei direttori mancanti 
                        $direttore = $corso->direttore();
                        if (!$direttore) {
                            $corso->stato = CORSO_S_DACOMPLETARE;
                        }

                        ?>

                    <tr>

                    	<td style="width: 20%;">
                            <?php echo $corso->organizzatore()->nomeCompleto(); ?>
                        </td>
                        <td style="width: 45%;">
                            <strong>
                                <a href="?p=formazione.corsibase.scheda&id=<?php echo $corso->id; ?>">
                                    <?php echo $corso->nome(); ?>
                                </a>
                            </strong><br />
                            Luogo:
                            <?php echo $corso->luogo; ?>
                            <br />
                            Data inizio:
                            <?php echo date('d/m/Y H:i', $corso->inizioDate()); ?>
                            <br />
                            Data esame:
                            <?php echo date('d/m/Y H:i', $corso->fineDate()); ?>
                            <br />
                            <?php if ( $corso->direttore ) { ?>
                            Direttore: 
                            <a href="?p=profilo.controllo&id=<?php echo $corso->direttore()->id; ?>" target="_new">
                                <?php echo $direttore->nomeCompleto(); ?>
                            </a>
                            <?php } else { ?>
                            <i class="icon-warning-sign"></i> Nessun referente
                            <?php } ?>
                            <br />
                            Codice corso: <?php echo($corso->progressivo());?>
                            <br />
                            Numero iscritti: <?php echo($corso->numIscritti());?>
                        </td>
                
                        <td style="width: 15%;">
                            <?php echo($conf['corso_stato'][$corso->stato]); ?>
                        </td>
                        
                        <td style="width: 20%;">
                            <?php if ((!$corso->concluso() 
                                        && in_array($corso->organizzatore(), $mieiComitati)) 
                                    || $me->admin()){ ?>
                            <a href="?p=formazione.corsibase.direttore&id=<?= $corso->id; ?>">
                                <i class="icon-pencil"></i> 
                                cambia direttore
                            </a>
                            <?php } 
                            if(!$corso->concluso()) {?>
                            <br />
                            <a href="?p=formazione.corsibase.modifica&id=<?php echo $corso->id; ?>">
                                <i class="icon-edit"></i> modifica corso
                            </a>
                            <?php }

                            if ((in_array($corso->organizzatore(), $mieiComitati) && $corso->cancellabile())
                                        or $me->admin()){ ?>
                            <br />
                            <a onClick="return confirm('Vuoi veramente cancellare questo corso base ?');" href="?p=formazione.corsibase.cancella.ok&id=<?php echo $corso->id; ?>">
                                <i class="icon-remove"></i> cancella
                            </a>
                            <?php } ?>
                        </td>
                        
                    </tr>

                    <?php } ?>

                </table>
            </div>
        </div>
    </div>

</div>