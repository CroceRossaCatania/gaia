<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaApp([APP_SOCI, APP_PRESIDENTE]);

controllaParametri(array('id'), 'presidente.riserva&err');

$v = $_GET['id'];
$v = Volontario::id($v);
proteggiDatiSensibili($v, [APP_SOCI, APP_PRESIDENTE]);
?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <h2>
                <i class="icon-certificate muted"></i>
                Storico Corsi Base
            </h2>
            <p>Volontario: <strong><?= $v->nomeCompleto(); ?></strong></p>
            
        </div>
        
        <div class="row-fluid">
            
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Esito</th>
                    <th>Data esame</th>
                    <th>Organizzato</th>
                    <th>Azioni</th>
                </thead>
                
                <?php foreach ( $v->corsiBase() as $pb ) { 
                    $corso = $pb->corsoBase(); ?>

                    <tr>
                        <td>
                            <?php echo $conf['partecipazioneBase'][$pb->stato]; ?>
                        </td>
                        
                        <td>
                            <?php echo date('d/m/Y', $corso->tEsame); ?>
                        </td>
                        
                        <td>
                            <?php echo $corso->organizzatore()->nomeCompleto(); ?>
                        </td>

                        <td>
                            <?php if ( $pb->stato == ISCR_SUPERATO ){ ?>
                                <a class="btn btn-small btn-success" href="?p=formazione.corsibase.valutazione&id=<?= $corso->id; ?>&iscritto=<?= $v->id; ?>" title="Attestati, verbale e schede esame">
                                    <i class="icon-paste"></i> Attestati, Verbale e schede esame
                                </a>
                            <?php } 
                                 if ( $pb->stato == ISCR_BOCCIATO ){ ?>
                                <a href="<?= "?p=formazione.corsibase.valutazione&id={$v->id}&corso={$corso->id}&single" ?>" class="btn bn-small btn-info" target="_new" title="Dettagli">
                                    <i class="icon-file-alt"></i> Scheda
                                </a>
                            <?php } ?>
                        </td>
                        
                    </tr>
                <?php } ?>
            
            </table>
        </div>        
    </div>
</div>

