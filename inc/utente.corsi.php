<?php

/*
 * ©2013 Croce Rossa Italiana
 */

if (isset($_GET['t'])) {
    $t = (int) $_GET['t'];
} else {
    $t = 0;
}
$titoli = $conf['Corsi'][$t];

paginaPrivata();

?>
<div class="row-fluid">
    <div class="span3">
        <?php        menuVolontario(); ?>
    </div>
    <div class="span9">
        

        

        
         <h2><i class="icon-beaker muted"></i> Titoli di Studio</h2>

         <select>
             <option>Direttore</option>
              <option>Docente</option>
               <option>Discente</option>
         </select>
             
            <div class="row-fluid">
                <div class="span12">
                    <?php $ttt = $me->titoliTipo($t); ?>
                    <?php $ttt = $me->titoliTipo($t); ?>
                    <h3><i class="icon-list muted"></i> Nel mio curriculum <span class="muted"><?php echo count($ttt); ?> inseriti</span></h3>
                    <table class="table table-striped">
                        <?php foreach ( $ttt as $titolo ) { ?>
                        <tr <?php if (!$titolo->tConferma) { ?>class="warning"<?php } ?>>
                            <td><strong><?php echo $titolo->titolo()->nome; ?></strong></td>
                            <td><?php echo $conf['titoli'][$titolo->titolo()->tipo][0]; ?></td>
                            <?php if ($titolo->tConferma) { ?>
                            <td>
                                <abbr title="<?php echo date('d-m-Y H:i', $titolo->tConferma); ?>">
                                    <i class="icon-ok"></i> Confermato
                                </abbr>
                            </td>    
                            <?php } else { ?>
                            <td><i class="icon-time"></i> Pendente</td>
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
                            
                            
                            <td>
                                <div class="btn-group">
                                    <?php if ( !$titolo->tConferma || $titolo->titolo()->tipo == TITOLO_PATENTE_CIVILE ) { ?>
                                    <a href="?p=utente.titolo.modifica&t=<?php echo $titolo->id; ?>" title="Modifica il titolo" class="btn btn-small btn-info">
                                        <i class="icon-edit"></i>
                                    </a>
                                    <?php } ?>
                                    <a  href="?p=utente.titolo.cancella&id=<?php echo $titolo->id; ?>" title="Cancella il titolo" class="btn btn-small btn-warning">
                                        <i class="icon-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        
                    </table>

                </div>
            </div>
         
         
         
         
            
         
         
            
        </div>
    </div>
