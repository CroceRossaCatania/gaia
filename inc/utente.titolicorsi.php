<?php

/*
 * ©2013 Croce Rossa Italiana
 */

if (isset($_GET['t'])) {
    $t = (int) $_GET['t'];
} else {
    $t = 0;
}
$titoli = $conf['titoli'][$t];

paginaPrivata();

?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
            
        <div class="row-fluid">

            <div class="span12">
                <?php $ttt = TitoloCorso::ultimo();
                
                
                ?>
                <h3><i class="icon-list muted"></i> Nel mio curriculum <span class="muted"><?php echo count($ttt); ?> inseriti</span></h3>
                <table class="table table-striped" width="100%">
                    <?php foreach ( $ttt as $titolo ) { 
                    print "|".$titolo->generaCodice()."|";
                    
                    ?>
                    <tr <?php if ($titolo->inScadenza()) { ?>class="warning"<?php } ?>
                        <?php if (!$titolo->valido()) { ?>class="error" style="background: pink"<?php } ?>                                     
                        >
                        <td><strong><?php echo $titolo->titolo()->nome; ?></strong></td>
                        <td><?php echo $conf['titoli'][$titolo->titolo()->tipo][0]; ?></td>
                        
                        <?php if ($titolo->valido()) { ?>
                        <td>
                            <?php if (!$titolo->inScadenza()) { ?>
                            <abbr title="<?php echo date('d-m-Y H:i', $titolo->tConferma); ?>">
                                <i class="icon-ok"></i> Valido
                            </abbr>
                            <?php } ?>
                            <?php if ($titolo->inScadenza()) { ?>
                            <abbr title="<?php echo date('d-m-Y H:i', $titolo->tConferma); ?>">
                                <i class="icon-exclamation"></i> In Scadenza
                            </abbr>
                            <?php } ?>
                        </td>    
                        <?php } else { ?>
                        <td>
                            <i class="icon-trash"></i> Scaduto
                        </td>
                        <?php } ?>
                        
                        <td><small>
                            <?php if ( $titolo->inizio ) { ?>
                            <i class="icon-calendar muted"></i>
                            <?php echo date('d-m-Y', $titolo->inizio); ?>
                            <br />
                            <?php } ?>
                            <?php if ( $titolo->fine ) { ?>
                            <i class="icon-time muted"></i>
                            <?php echo date('d-m-Y', $titolo->fine); ?>
                            <br />
                            <?php } ?>
                            <?php if ( $titolo->luogo ) { ?>
                            <i class="icon-road muted"></i>
                            <?php echo $titolo->luogo; ?>
                            <br />
                            <?php } ?>
                            <?php if ( $titolo->codice ) { ?>
                            <i class="icon-barcode muted"></i>
                            <?php echo $titolo->codice; ?>
                            <br />
                            <?php } ?>

                        </small></td>
                    </tr>
                    <?php } ?>

                </table>

            </div>
            
            <div class="span12">
                <?php $ttt = $me->titoliCorsi(); ?>
                <h3><i class="icon-list muted"></i> Nel mio curriculum <span class="muted"><?php echo count($ttt); ?> inseriti</span></h3>
                <table class="table table-striped" width="100%">
                    <?php foreach ( $ttt as $titolo ) { ?>
                    <tr <?php if ($titolo->inScadenza()) { ?>class="warning"<?php } ?>
                        <?php if (!$titolo->valido()) { ?>class="error" style="background: pink"<?php } ?>                                     
                        >
                        <td><strong><?php echo $titolo->titolo()->nome; ?></strong></td>
                        <td><?php echo $conf['titoli'][$titolo->titolo()->tipo][0]; ?></td>
                        
                        <?php if ($titolo->valido()) { ?>
                        <td>
                            <?php if (!$titolo->inScadenza()) { ?>
                            <abbr title="<?php echo date('d-m-Y H:i', $titolo->tConferma); ?>">
                                <i class="icon-ok"></i> Valido
                            </abbr>
                            <?php } ?>
                            <?php if ($titolo->inScadenza()) { ?>
                            <abbr title="<?php echo date('d-m-Y H:i', $titolo->tConferma); ?>">
                                <i class="icon-exclamation"></i> In Scadenza
                            </abbr>
                            <?php } ?>
                        </td>    
                        <?php } else { ?>
                        <td>
                            <i class="icon-trash"></i> Scaduto
                        </td>
                        <?php } ?>
                        
                        <td><small>
                            <?php if ( $titolo->inizio ) { ?>
                            <i class="icon-calendar muted"></i>
                            <?php echo date('d-m-Y', $titolo->inizio); ?>
                            <br />
                            <?php } ?>
                            <?php if ( $titolo->fine ) { ?>
                            <i class="icon-time muted"></i>
                            <?php echo date('d-m-Y', $titolo->fine); ?>
                            <br />
                            <?php } ?>
                            <?php if ( $titolo->luogo ) { ?>
                            <i class="icon-road muted"></i>
                            <?php echo $titolo->luogo; ?>
                            <br />
                            <?php } ?>
                            <?php if ( $titolo->codice ) { ?>
                            <i class="icon-barcode muted"></i>
                            <?php echo $titolo->codice; ?>
                            <br />
                            <?php } ?>

                        </small></td>
                    </tr>
                    <?php } ?>

                </table>

            </div>
        </div>

    </div>
</div>
