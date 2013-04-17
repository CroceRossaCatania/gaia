<?php

/*
 * ©2013 Croce Rossa Italiana
 */

paginaPresidenziale();
caricaSelettore();

$id = $_GET['id'];
$c = new Comitato($id);

?>

<div class="row-fluid">
    <div class="span3">
        <?php menuVolontario(); ?>
    </div>
    <div class="span9">
        
        <h3><i class="icon-certificate muted"></i> Obiettivi strategici</h3>
        <h4><?php echo $c->nomeCompleto(); ?></h4>
        <hr />
        
            
            <?php foreach ( $conf['obiettivi'] as $num => $nome ) { ?>
            
            <div class="row-fluid allinea-centro">
                <div class="span5">
                    <i class="icon-certificate"></i> 
                    <strong><?php echo $nome; ?></strong>
                </div>
                <div class="span7">
                    
                    <?php
                    $o = $c->obiettivi($num);
                    
                    if ($o) {
                        $o = $o[0];
                    ?>
                    <a data-autosubmit="true" data-selettore="true" data-input="<?php echo $num; ?>" class="btn">
                        <?php echo $o->nomeCompleto(); ?> <i class="icon-pencil"></i> 
                    </a> 
                    <?php } else { ?>
                    <a data-autosubmit="true" data-selettore="true" data-input="<?php echo $num; ?>" class="btn btn-warning">
                        Seleziona volontario... <i class="icon-pencil"></i>
                    </a> 
                    <?php } ?>
                    
                </div>
            </div>
            <hr />
        
            <?php } ?>

    </div>
</div>
            
