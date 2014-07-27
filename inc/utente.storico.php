<?php

/*
 * ©2014 Croce Rossa Italiana
 */

paginaPrivata();
?>
<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        <?php if ( isset($_GET['ester']) ) { ?>
            <div class="alert alert-success">
                <i class="icon-save"></i> <strong>Estensione Terminata</strong>.
                La tua estensione è stata terminata con successo.
            </div>
        <?php } ?>
        <?php if ( isset($_GET['rister']) ) { ?>
            <div class="alert alert-success">
                <i class="icon-save"></i> <strong>Riserva Terminata</strong>.
                La tua riserva è stata terminata con successo.
            </div>
        <?php } ?>
        <?php if ( isset($_GET['err']) ) { ?>
            <div class="alert alert-danger">
                <i class="icon-warning-sign"></i> <strong>Qualcosa non ha funzionato</strong>.<br />
                L'operazione che hai tentato di eseguire non è andata a buon fine, per favore riprova.
            </div>
        <?php } ?>
        <?php if ( isset($_GET['quotaAnn']) ) { ?>
            <div class="alert alert-danger">
                <i class="icon-warning-sign"></i> <strong>Quota annullata</strong>.<br />
                Stai cercando di visualizzare una quota che è stata in precedenza annullata.
            </div>
        <?php } ?>
        <?php if ( $me->iv() || $me->cm() ) { ?>
            <div class="row-fluid">
                <h2>
                    <i class="icon-asterisk muted"></i>
                    <?php if ( $me->iv() ) { ?>
                        Infermiera volontaria
                    <?php }elseif ( $me->cm() ) { ?>
                        Corpo Militare Volontario
                    <?php } ?>
                </h2>    
            </div>
        <?php } ?>
        <div class="row-fluid">
            <h2>
                <i class="icon-time muted"></i>
                Appartenenze
            </h2>
        </div>
        <div class="row-fluid">
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Stato</th>
                    <th>Ruolo</th>
                    <th>Comitato</th>
                    <th>Inizio</th>
                    <th>Fine</th>
                    <th>Azioni</th>
                </thead>
                <?php foreach ( $me->storico() as $app ) { ?>
                <tr<?php if ($app->attuale()) { ?> class="success"<?php } ?>>
                <td>
                    <?php if ($app->attuale()) { ?>
                    Attuale
                    <?php } else { ?>
                    Passato
                    <?php } ?>
                </td>
                
                <td>
                    <strong><?php echo $conf['membro'][$app->stato]; ?></strong>
                </td>
                
                <td>
                    <?php echo $app->comitato()->nomeCompleto(); ?>
                </td>
                
                <td>
                    <i class="icon-calendar muted"></i>
                    <?php echo $app->inizio()->inTesto(false); ?>
                </td>
                
                <td>
                    <?php if ($app->fine) { ?>
                    <i class="icon-time muted"></i>
                    <?php echo $app->fine()->inTesto(false); ?>
                    <?php } else { ?>
                    <i class="icon-question-sign muted"></i>
                    Indeterminato
                    <?php } ?>
                </td>
                <td>
                    <?php if ( $app->stato == MEMBRO_ESTESO ){ ?>
                    <a class="btn btn-small btn-danger" href="?p=utente.estensione.termina&id=<?= $app->id; ?>" title="Termina Estensione">
                        Termina
                    </a> 
                    <?php } ?>
                </td>
                
            </tr>
            <?php } ?>
            
        </table>
    </div>

    <!-- VISUALIZZAZIONE DELLE QUOTE -->

    <?php if ( $me->quote() ){ ?>
    <div class="row-fluid">
        <h2>
            <i class="icon-money muted"></i>
            Riepilogo Quote
        </h2>
    </div>
    
    <div class="row-fluid">
        
        <table class="table table-bordered table-striped">
            <thead>
                <th>N.</th>
                <th>Comitato</th>
                <th>Data versamento</th>
                <th>Quota</th>
                <th>Azioni</th>
            </thead>
            <?php foreach ( $me->quote() as $_q ){ ?>
            <tr>
                <td><?= $_q->progressivo(); ?></td>
                <td><?= $_q->comitato()->locale()->nomeCompleto(); ?></td>
                <td><?= $_q->dataPagamento()->inTesto(false); ?></td>
                <td>
                    <?php if ($_q->benemerita()) { 
                        echo('€ ' . soldi($_q->quota)); 
                        ?>
                        <i class="icon-thumbs-up-alt"></i> Sostenitore
                    <?php } else { 
                        echo('€ ' . soldi($_q->quota));
                    } ?>
                </td>
                <td>
                    <?php if(!$_q->annullata()) { ?>
                    <a class="btn btn-small btn-info" href="?p=utente.quote.ricevuta&id=<?= $_q->id; ?>" title="Visualizza ricevuta">
                        <i class="icon-paperclip"></i> Ricevuta
                    </a>
                    <?php } else { ?>
                        Annullata da <?= $_q->annullatore()->nomeCompleto(); ?>
                        il giorno <?= $_q->dataAnnullo()->format('d/m/Y'); ?>
                    <?php }?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <?php } ?>

    <?php if ( $me->riserve() ) { ?>
    <div class="row-fluid">
        <h2>
            <i class="icon-pause muted"></i>
            Riserve
        </h2>
        
    </div>
    
    <div class="row-fluid">
        
        <table class="table table-bordered table-striped">
            <thead>
                <th>Stato</th>
                <th>Ruolo</th>
                <th>Motivo riserva</th>
                <th>Inizio</th>
                <th>Fine</th>
                <th>Azioni</th>
            </thead>
            
            <?php foreach ( $me->riserve() as $app ) { ?>
            <tr<?php if ($app->attuale()) { ?> class="success"<?php } ?>>
            <td>
                <?php if ($app->attuale()) { ?>
                Attuale
                <?php } else { ?>
                Passato
                <?php } ?>
            </td>
            
            <td>
                <strong><?php echo $conf['riserve'][$app->stato]; ?></strong>
            </td>
            
            <td>
                <?php echo $app->motivo; ?>
            </td>
            
            <td>
                <i class="icon-calendar muted"></i>
                <?php echo $app->inizio()->inTesto(false); ?>
            </td>
            
            <td>
                <?php if ($app->fine) { ?>
                <i class="icon-time muted"></i>
                <?php echo $app->fine()->inTesto(false); ?>
                <?php } else { ?>
                <i class="icon-question-sign muted"></i>
                Indeterminato
                <?php } ?>
            </td>
            <td>
                <?php if ( $app->attuale() ){ ?>
                <a class="btn btn-small btn-danger" href="?p=utente.riserva.termina&id=<?= $app->id; ?>" title="Termina Riserva">
                    Termina
                </a> 
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        
    </table>
</div> 
<?php } ?>        

<?php if ( $me->storicoDelegazioni() ) { ?>
<div class="row-fluid">
    <h2>
        <i class="icon-briefcase muted"></i>
        Incarichi
    </h2>
    
</div>

<div class="row-fluid">
    
    <table class="table table-bordered table-striped">
        <thead>
            <th>Stato</th>
            <th>Ruolo</th>
            <th>Comitato</th>
            <th>Inizio</th>
            <th>Fine</th>
        </thead>
        
        <?php foreach ( $me->storicoDelegazioni() as $app ) { ?>
        <tr<?php if ($app->fine >= time() || $app->fine == 0 ) { ?> class="success"<?php } ?>>
        <td>
            <?php if ($app->fine >= time() || $app->fine == 0 ) { ?>
            Attuale
            <?php } else { ?>
            Passato
            <?php } ?>
        </td>
        
        <td>
            <?php switch ( $app->applicazione ) { 
                case APP_PRESIDENTE:
                ?>
                <strong>Presidente</strong>
                <?php
                break;
                case APP_ATTIVITA:
                ?>
                <strong>Referente</strong>
                <?php echo $conf['app_attivita'][$app->dominio]; ?>
                <?php
                break;
                case APP_OBIETTIVO:
                ?>
                <strong>Delegato</strong>
                <?php echo $conf['obiettivi'][$app->dominio]; ?>
                <?php
                break;
                default:
                ?>
                <strong><?php echo $conf['applicazioni'][$app->applicazione]; ?></strong>
                <?php
                break;
                
            }
            ?>
            
        </td>
        
        <td>
            <?php echo $app->comitato()->nomeCompleto(); ?>
        </td>
        
        <td>
            <i class="icon-calendar muted"></i>
            <?php echo $app->inizio()->inTesto(false); ?>
        </td>
        
        <td>
            <?php if ($app->fine) { ?>
            <i class="icon-time muted"></i>
            <?php echo $app->fine()->inTesto(false); ?>
            <?php } else { ?>
            <i class="icon-question-sign muted"></i>
            Indeterminato
            <?php } ?>
        </td>
        
    </tr>
                <?php } ?>
            </table>
        </div>
        <?php } ?>
    </div>
</div>
